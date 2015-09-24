var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var fileInclude = require('gulp-file-include');
var imagemin = require('gulp-imagemin');
var pixrem = require('gulp-pixrem');
var sass = require('gulp-sass');
var mainBowerFiles = require('main-bower-files');
var browserSync = require('browser-sync');
var reload = browserSync.reload;

gulp.task('fonts-bower', function() {
  return gulp.src(mainBowerFiles({filter: ['**/*.otf', '**/*.eot', '**/*.svg', '**/*.ttf', '**/*.woff', '**/*.woff2']}))
    .pipe(gulp.dest('fonts'))
    .pipe(reload({stream: true}));
});

gulp.task('fonts', function() {
  return gulp.src('src/fonts/**/*')
    .pipe(gulp.dest('fonts'))
    .pipe(reload({stream: true}));
});

gulp.task('css', function() {
  return gulp.src('src/scss/*.scss')
    .pipe(sass({errLogToConsole: true}))
    .pipe(autoprefixer({browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1', 'Android >= 2']}))
    .pipe(pixrem('16px', {atrules: true}))
    .pipe(gulp.dest('css'))
    .pipe(reload({stream: true}));
});

gulp.task('css-bower', function() {
  return gulp.src(mainBowerFiles({filter: (/.*\.css$/i)}))
    .pipe(concat('style-bower.css'))
    .pipe(gulp.dest('css'))
    .pipe(reload({stream: true}));
});

gulp.task('js', function() {
  return gulp.src('src/js/*.js')
    .pipe(fileInclude())
    .pipe(gulp.dest('js'))
    .pipe(reload({stream: true}));
});

gulp.task('js-bower', function() {
  return gulp.src(mainBowerFiles({filter: (/.*\.js$/i)}))
    .pipe(concat('script-bower.js'))
    .pipe(gulp.dest('js'))
    .pipe(reload({stream: true}));
});

gulp.task('img', function() {
  return gulp.src('src/img/**/*')
    .pipe(imagemin())
    .pipe(gulp.dest('img'))
    .pipe(reload({stream: true}));
});

gulp.task('browser-sync', ['fonts-bower', 'fonts', 'css', 'css-bower', 'js', 'js-bower', 'img'], function() {
  return browserSync({
    proxy: 'jhu-hsa.dev',
    open: 'ui',
    files: '*.php'
  });
});

gulp.task('watch', ['browser-sync'], function() {
  gulp.watch('src/fonts/**/*', ['fonts']);
  gulp.watch('src/scss/**/*', ['css']);
  gulp.watch('src/js/**/*', ['js']);
  gulp.watch('src/img/**/*', ['img']);
  gulp.watch('bower_components/**/*', ['fonts-bower', 'css-bower', 'js-bower']);
});

gulp.task('default', ['watch']);