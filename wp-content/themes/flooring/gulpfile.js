var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemap = require('gulp-sourcemaps'),
    lec = require('gulp-line-ending-corrector'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat');
    livereload = require('gulp-livereload');

function scripts() {
  return (
      gulp
      .src([
        // plugins
        './js/plugins/foundation.min.js',
        './js/plugins/what-input.min.js',
        './js/plugins/owl-carousel.js',
        './js/plugins/owl.carousel2.js',
        './js/plugins/isotope.js',
        './js/plugins/modernizr.js',
        './js/plugins/Parallax.js',
        './js/plugins/LocalScroll.js',
        './js/plugins/appear.js',
        './js/plugins/smoothscroll.js',
        './js/plugins/classie.js',
        './js/plugins/IsMobile.js',
        './js/plugins/idangero.js',
        './js/plugins/Waypoints.js',
        './js/plugins/counterup.js',
        // main scripts
        './js/all-js/wd_owlcarousel.js',
        './js/shortcode/script-shortcodes.js',
        './js/all-js/scripts.js'
      ]).pipe(lec({verbose: true, eolc: 'LF', encoding: 'utf8'}))
        .pipe(concat('wd-script.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js'))
        .pipe(livereload())
  );
}

function styles() {
  return (
      gulp.src('./scss/**/*.scss')
          .pipe(sourcemap.init())
          .pipe(sass({
            outputStyle: 'compressed'
          }).on('error', sass.logError))
          .pipe(sourcemap.write({includeContent: false}))
          .pipe(sourcemap.init({loadMaps: true}))
          //.pipe(autoprefixer({browsers: ['last 2 versions']}))
          .pipe(sourcemap.write('.'))
          .pipe(lec({verbose: true, eolc: 'LF', encoding: 'utf8'}))
          .pipe(gulp.dest('css'))
          .pipe(livereload())
  );
}

function watch() {
  livereload.listen();

  gulp.watch('scss/**/*.scss', styles);
  gulp.watch(['js/**/*.js', '!js/wd-script.min.js'], scripts)
}


//Task calling 'styles' function
gulp.task('styles', styles);
//Task calling 'scripts' function
gulp.task('scripts', scripts);

//Task for changes tracking
gulp.task('watch', watch);

gulp.task('build', gulp.series( gulp.parallel(styles,scripts)) );

//Default task
gulp.task('default', gulp.series('styles', 'scripts', 'watch'));