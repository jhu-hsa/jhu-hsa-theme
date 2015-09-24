// start jquery.pan embed
// https://github.com/mjfisheruk/jquery.pan
// modified to work with window resizing and added minWidth option

(function( $ ){

    var getSize = function($element) {
        return {
            'width': $element.width(),
            'height': $element.height()
        };
    };

    var toCoords = function(x, y) {
        return {'x': x, 'y': y};
    };

    var vectorsEqual = function(v1, v2) {
        return v1.x == v2.x && v1.y == v2.y;
    };

    $.fn.pan = function(options) {

        //Container is element this plugin is applied to;
        //we're pan it's child element, content
        var container = this;
        var content = this.children(':first');

        //Precalculate the limits of panning - offset stores
        //the current amount of pan throughout
        var offset = toCoords(
            Number(content.css('left').replace('px', '')) | 0,
            Number(content.css('top').replace('px', ''))  | 0
        );

        var containerSize = getSize(container);
        var contentSize = getSize(content);

        // ADDITION
        $(window).on('resize', function() {
          containerSize = getSize(container);
          contentSize = getSize(content);
        });

        var minOffset = toCoords(
            -contentSize.width + containerSize.width,
            -contentSize.height + containerSize.height
        );

        // ADDITION
        $(window).on('resize', function() {
          minOffset = toCoords(
              -contentSize.width + containerSize.width,
              -contentSize.height + containerSize.height
          );
        });

        var maxOffset = toCoords(0, 0);

        //By default, assume mouse sensitivity border
        //is 25% of the smallest dimension
        var defaultMouseEdge = 0.25 * Math.min(
            containerSize.width,
            containerSize.height
        );

        var settings = $.extend( {
            'autoSpeedX'            : 0,
            'autoSpeedY'            : 0,
            'mouseControl'          : 'kinetic',
            'kineticDamping'        : 0.8,
            'mouseEdgeSpeed'        : 5,
            'mouseEdgeWidth'        : defaultMouseEdge,
            'proportionalSmoothing' : 0.5,
            'updateInterval'        : 50,
            'mousePan'              : null,
            'minWidth'              : null
        }, options);

        //Mouse state variables, set by bound mouse events below
        var mouseOver = false;
        var mousePanningDirection = toCoords(0, 0);
        var mousePosition = toCoords(0, 0);

        var dragging = false;
        var lastMousePosition = null;
        var kineticVelocity = toCoords(0, 0);

        //Delay in ms between updating position of content
        var updateInterval = settings.updateInterval;

        var onInterval = function() {

            var mouseControlHandlers = {
                'edge'          : updateEdge,
                'proportional'  : updateProportional,
                'kinetic'       : updateKinetic
            };

            var currentHandler = settings.mouseControl;

            if(!mouseControlHandlers[currentHandler]()) {
                //The handler isn't active - just pan normally
                offset.x += settings.autoSpeedX;
                offset.y += settings.autoSpeedY;
            }

            //If the previous updates have take the content
            //outside the allowed min/max, bring it back in
            constrainToBounds();

            //If we're panning automatically, make sure we're
            //panning in the right direction if the content has
            //moved as far as it can go
            if(offset.x == minOffset.x) settings.autoSpeedX = Math.abs(settings.autoSpeedX);
            if(offset.x == maxOffset.x) settings.autoSpeedX = -Math.abs(settings.autoSpeedX);
            if(offset.y == minOffset.y) settings.autoSpeedY = Math.abs(settings.autoSpeedY);
            if(offset.y == maxOffset.y) settings.autoSpeedY = -Math.abs(settings.autoSpeedY);

            //Finally, update the position of the content
            //with our carefully calculated value
            content.css('left', offset.x + "px");
            content.css('top', offset.y + "px");
        };

        var updateEdge = function() {

            if(!mouseOver) return false;

            //The user's possibly maybe mouse-navigating,
            //so we'll find out what direction in case we need
            //to handle any callbacks
            var newDirection = toCoords(0, 0);

            //If we're in the interaction zones to either
            //end of the element, pan in response to the
            //mouse position.
            if(mousePosition.x < settings.mouseEdgeWidth) {
                offset.x += settings.mouseEdgeSpeed;
                newDirection.x = -1;
            }
            if (mousePosition.x > containerSize.width - settings.mouseEdgeWidth) {
                offset.x -= settings.mouseEdgeSpeed;
                newDirection.x = 1;
            }
            if(mousePosition.y < settings.mouseEdgeWidth) {
                offset.y += settings.mouseEdgeSpeed;
                newDirection.y = -1;
            }
            if (mousePosition.y > containerSize.height - settings.mouseEdgeWidth) {
                offset.y -= settings.mouseEdgeSpeed;
                newDirection.y = 1;
            }

            updateMouseDirection(newDirection);

            return true;
        };

        var updateProportional = function() {

            if(!mouseOver) return false;

            var rx = mousePosition.x / containerSize.width;
            var ry = mousePosition.y / containerSize.height;
            targetOffset = toCoords(
                (minOffset.x - maxOffset.x) * rx + maxOffset.x,
                (minOffset.y - maxOffset.y) * ry + maxOffset.y
            );

            var damping = 1 - settings.proportionalSmoothing;
            offset = toCoords(
                (targetOffset.x - offset.x) * damping + offset.x,
                (targetOffset.y - offset.y) * damping + offset.y
            );

            return true;
        };

        var updateKinetic = function() {
            if(dragging) {

                if(lastMousePosition === null) {
                    lastMousePosition = toCoords(mousePosition.x, mousePosition.y);
                }

                kineticVelocity = toCoords(
                    mousePosition.x - lastMousePosition.x,
                    mousePosition.y - lastMousePosition.y
                );

                lastMousePosition = toCoords(mousePosition.x, mousePosition.y);
            }

            offset.x += kineticVelocity.x;
            offset.y += kineticVelocity.y;

            kineticVelocity = toCoords(
                kineticVelocity.x * settings.kineticDamping,
                kineticVelocity.y * settings.kineticDamping
            );

            //If the kinetic velocity is still greater than a small threshold, this
            //function is still controlling movement so we return true so autopanning
            //doesn't interfere.
            var speedSquared = Math.pow(kineticVelocity.x, 2) + Math.pow(kineticVelocity.y, 2);
            return speedSquared > 0.01;
        };

        var constrainToBounds = function() {
            if(offset.x < minOffset.x) offset.x = minOffset.x;
            if(offset.x > maxOffset.x) offset.x = maxOffset.x;
            if(offset.y < minOffset.y) offset.y = minOffset.y;
            if(offset.y > maxOffset.y) offset.y = maxOffset.y;
        };

        var updateMouseDirection = function(newDirection) {
            if(!vectorsEqual(newDirection, mousePanningDirection)) {
                mousePanningDirection = newDirection;
                if(settings.mousePan) {
                   settings.mousePan(mousePanningDirection);
                }
            }
        };

        this.bind('mousemove', function(evt) {
            mousePosition.x = evt.pageX - container.offset().left;
            mousePosition.y = evt.pageY - container.offset().top;
            mouseOver = true;
        });

        this.bind('mouseleave', function(evt) {
            mouseOver = false;
            dragging = false;
            lastMousePosition = null;
            updateMouseDirection(toCoords(0, 0));
        });

        this.bind('mousedown', function(evt) {
            dragging = true;
            return false; //Prevents FF from thumbnailing & dragging
        });

        this.bind('mouseup', function(evt) {
            dragging = false;
            lastMousePosition = null;
        });

        if (settings.minWidth !== null) {
          $(window).on('load resize', function() {
            if ((window.innerWidth ? window.innerWidth : $(window).width()) < settings.minWidth) {
              minOffset = toCoords(0, 0);
            }
          });
        }

        //Kick off the main panning loop and return
        //this to maintain jquery chainability
        setInterval(onInterval, updateInterval);
        return this;
    };

})( jQuery );

// end jquery.pan embed

// randomize function
(function($) {
$.fn.randomize = function(childElem) {
  return this.each(function() {
      var $this = $(this);
      var elems = $this.children(childElem);

      elems.sort(function() { return (Math.round(Math.random())-0.5); });  

      $this.detach(childElem);  

      for(var i=0; i < elems.length; i++)
        $this.append(elems[i]);      

  });    
}
})(jQuery);

jQuery(function($) {

  var transitionSpeed = 500;
  var transitionEasing = 'easeInOutQuint';
  var transitionEasingCss = 'cubic-bezier(0.86, 0, 0.07, 1)';

  // rem function
  var rem = function (count) {
    var unit = $('html').css('font-size');
    if (typeof count !== 'undefined' && count > 0) {
      return (parseInt(unit) * count);
    }
    else {
      return parseInt(unit);
    }
  };

  // menu toggle
  $('.menu-toggle').on('click', function() {
    $('body').toggleClass('menu--active');
  });

  // menu sub toggle
  $('.menu__sub > a').on('click', function() {
    $('.menu__sub > a').not($(this)).parent().removeClass('menu__sub--active');
    $(this).parent().toggleClass('menu__sub--active');
  });

  // menu sub close on outside interaction
  $(document).on('click', function(e) {
    var container = $('.menu__sub--active');
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.removeClass('menu__sub--active');
    }
  });

  // menu search toggle
  $('.menu__search__toggle').on('click', function() {
    $('body').toggleClass('menu__search--active');
  });

  // wrap all tables with table-wrap class
  $('table').each(function() {
    $(this).wrap('<div class="table-overthrow overthrow"><div class="table-wrap"></div></div>');
  });

  // matchHeight
  $('.list-grid > ul > li > a').matchHeight();
  $('.list-grid__toggle > a').matchHeight();
  $('.staff__info').matchHeight();
  $('.feed__item').matchHeight();
  $('.social__slider--feed__item').matchHeight();

  // splash
  if ($('.splash').length) {

    // splash height
    $(window).on('load resize', function() {
      var viewportHeight = window.innerHeight ? window.innerHeight : $(window).height();
      var headerHeight = $('.header').outerHeight();
      var menuToggleHeight = 0;
      var menuHeight = 0;
      var breadcrumbsHeight = 0;
      if ($('.menu-toggle').css('display') === 'block') {
        menuToggleHeight = $('.menu-toggle').outerHeight();
      }
      if ($('.menu').css('position') !== 'absolute') {
        menuHeight = $('.menu').outerHeight();
      }
      if ($('.breadcrumbs').css('display') === 'block') {
        breadcrumbsHeight = $('.breadcrumbs').outerHeight();
      }
      var splashHeight = viewportHeight - headerHeight - menuToggleHeight - menuHeight - breadcrumbsHeight;
      $('.splash').css('height', splashHeight);
      var splashWrapHeight = $('.splash').outerHeight();
      $('.splash-wrap').css('height', splashWrapHeight);
    });

    // splash scroll
    var lastScrollEnd = 0;
    $(window).on('load scroll touchmove', function() {
      var viewportHeight = window.innerHeight ? window.innerHeight : $(window).height();
      var splashEdge = ($('.splash').offset().top + $('.splash').outerHeight()) - viewportHeight;
      if (splashEdge < 0) {
        splashEdge = 0;
      }
      var scrollEnd = $(window).scrollTop();
      if (scrollEnd > splashEdge && lastScrollEnd < scrollEnd) {
        $('body').addClass('splash--scrolled');
      }
      lastScrollEnd = scrollEnd;
    });

    // splash scroll expand
    $('.splash__expand').on('click', function() {
      $('body').toggleClass('splash--scrolled');
    });

  }

  // list grid toggle
  $('.list-grid__toggle > a').on('click', function() {
    var grid = $(this).closest('.list-grid > ul');
    var item = $(this).closest('> li', grid);
    var index = item.index();
    if (item.hasClass('list-grid__item--active')) {
      $('> li', grid).not(item).removeClass('list-grid__item--active');
      $('> li', grid).not(item).removeClass('list-grid__item--inactive');
      item.removeClass('list-grid__item--active');
      if (index%2 === 0) {
        item.next().removeClass('list-grid__item--inactive');
      } else {
        item.prev().removeClass('list-grid__item--inactive');
      }
    } else {
      $('> li', grid).not(item).removeClass('list-grid__item--active');
      $('> li', grid).not(item).removeClass('list-grid__item--inactive');
      item.addClass('list-grid__item--active');
      if (index%2 === 0) {
        item.next().addClass('list-grid__item--inactive');
      } else {
        item.prev().addClass('list-grid__item--inactive');
      }
    }
  });

  // collage pan
  if ($('.collage').length) {
    $('.collage').pan({
      mouseControl: 'proportional',
      minWidth: 1024
    });
  }

  // social slider
  $(window).on('load', function() {
    if (!$('html').hasClass('ie8')) {
      var socialSliderIndex = 0;
      $('.social__slider').each(function() {
        $(this).attr('id', 'social__slider__' + socialSliderIndex);
        var socialSlider = new IScroll('#social__slider__' + socialSliderIndex, {
          scrollX: true,
          scrollY: false,
          eventPassthrough: true,
          bounceEasing: {
            style: transitionEasingCss,
            fn: function(k) {
              return k;
            }
          },
          bounceTime: transitionSpeed
        });
        socialSliderIndex++;
      });
    }
  });

  // feature slider
  $('.feature__slider').each(function() {
    var slider = $(this);
    slider.slick({
      arrows: false,
      cssEase: transitionEasingCss,
      easing: transitionEasing,
      speed: transitionSpeed
    });
    $('.feature__slider__image', slider).each(function() {
      var index = parseInt($(this).parent().attr('data-slick-index')) + 1;
      var total = $(this).parent().siblings().length - 1;
      if (total > 0) {
        $(this).html('<a class="slick-prev"><span>Previous</span></a><a class="slick-next"><span>Next</span></a>');
        // counter removed <div class="feature__slider__count">' + index + '/' + total + '</div>
      }
    });
    $('.slick-prev', slider).on('click', function() {
      slider.slick('slickPrev');
    });
    $('.slick-next', slider).on('click', function() {
      slider.slick('slickNext');
    });
  });

  // resource finder
  $('.resource-finder a').on('click', function() {
    if ($(this).next('.resource-finder__dropdown').length) {
      var target = $(this).next('.resource-finder__dropdown');
      $('.resource-finder__dropdown').not(target).removeClass('resource-finder__dropdown--active');
      target.toggleClass('resource-finder__dropdown--active');
    }
  });

  // list accordion
  $('.list-accordion__toggle').on('click', function() {
    $(this).parent().toggleClass('list-accordion__item--active');
  });

  // sidebar nav
  $('.sidebar__nav__toggle').on('click', function() {
    $(this).toggleClass('sidebar__nav__toggle--active');
    $(this).next().toggleClass('sidebar__nav--active');
  });

  // add class once page has loaded
  $(window).on('load', function() {
    $('html').addClass('loaded');
  });

  // randomize social feed
  $('.social__slider--feed > ul').randomize('.social__slider--feed > ul > li');

});