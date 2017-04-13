      <a class="menu-toggle"></a>
      <nav class="menu" role="navigation" aria-label="find resources">
        <span class="menu__title">Find Resources Based On:</span>
        <?php switch_to_blog(1); ?>
          <ul>
		  <li class="menu__sub">
              <a>Who You Are</a>
              <ul class="menu__sub__dropdown">
                <?php wp_nav_menu(array(
                  'menu' => 'who',
                  'container' => false,
                  'items_wrap' => '%3$s'
                )); ?>
              </ul>
            </li>
            <li class="menu__sub">
              <a>What You Need</a>
              <ul class="menu__sub__dropdown">
                <?php wp_nav_menu(array(
                  'menu' => 'what',
                  'container' => false,
                  'items_wrap' => '%3$s'
                )); ?>
              </ul>
            </li>            
            <?php wp_nav_menu(array(
              'menu' => 'header',
              'container' => false,
              'items_wrap' => '%3$s'
            )); ?>
          </ul>
        <?php restore_current_blog(); ?>
              <!--<div class="menu__search-wrap">
          <form class="menu__search" method="get" action="https://www.jhu.edu/search">
            <a class="menu__search__toggle"><span>Search</span></a>
            <label for="search">Search</label>
            <input class="menu__search__input" id="search" type="search" placeholder="Search for topics &amp; people" name="q">
          </form>
        </div>
      </nav>-->
	  <div class="menu__search-wrap" role="search" aria-label="hsaandjhulabel">
	
   
          <form class="menu__search" method="get"  name="searchform" onsubmit="select()">	
            <a class="menu__search__toggle"><span>Search</span></a>
            <label for="search">Search</label>
            <input class="menu__search__input" id="search" type="search" placeholder="Search Homewood Student Affairs" name="s" aria-label="query field">
		 <fieldset >
		 <legend>Search</legend>
		<span class="menu-search-select" role="group" aria-label="select what you want to search by">
				<span class="hsa-radio">
					<input type="radio" id="hsasearch" name="check" checked="checked" onclick="ModifyPlaceHolder2()"/> 
					<label for="hsasearch" style="display: inline;">
					<span><span></span></span>Search HSA
					</label>
				</span>
				<span class="jhu-radio">
					<input type="radio" id="jhusearch" name="check"  onclick="ModifyPlaceHolder1()"/> 
					<label for="jhusearch" style="display: inline;">
					<span><span></span></span>Search JHU
					</label>
				</span>
   
   </span>	
    </fieldset>
    <input type="submit" value="Submit" style="position:absolute;left:-9999px;">
          </form>
		  <script>

function select()
    {
     var1=document.getElementById("hsasearch");
     var2=document.getElementById("jhusearch");
	 
     if(var1.checked==true)
     {
       document.searchform.action="<?php echo network_site_url(); ?>"; 
     }
     else
     {
       document.searchform.action="https://www.jhu.edu/search"; 
     }
   }
function ModifyPlaceHolder1() {
    var input = document.getElementById("search");
    input.placeholder = "Search Johns Hopkins University";
	 input.name = "q";
}

function ModifyPlaceHolder2() {
    var input = document.getElementById("search");
    input.placeholder = "Search Homewood Student Affairs";
	input.name = "s";
}

</script>
        </div>
      </nav>