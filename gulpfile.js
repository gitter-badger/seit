var path = require('path');
var gulp = require('gulp');
var less = require('gulp-less');
var uglify = require('gulp-uglify');
var minifyCSS = require('gulp-minify-css');
var sourcemaps = require('gulp-sourcemaps');
var lazypipe = require('lazypipe');
var phplint = require('phplint').lint;

var lessify = lazypipe()
    .pipe(sourcemaps.init)
    .pipe(less)
    .pipe(minifyCSS)
    .pipe(sourcemaps.write,'.');

gulp.task('less', function () {
  gulp.src(['./resources/assets/less/AdminLTE.less'])
    .pipe(less())
    .pipe(gulp.dest('./public/app/css'));
  gulp.src(['./resources/assets/less/skins/*.less'])
    .pipe(less())
    .pipe(gulp.dest('./public/app/css/skins'));
});

gulp.task('less-min', function () {
  gulp.src(['./resources/assets/less/AdminLTE.less'])
    .pipe(lessify())
    .pipe(gulp.dest('./public/app/css'));
  gulp.src(['./resources/assets/less/skins/*.less'])
    .pipe(lessify())
    .pipe(gulp.dest('./public/app/css/skins'));
});

gulp.task('js', function () {
  gulp.src(['./resources/assets/js/*.js'])
    .pipe(gulp.dest('./public/app/js')); 
});

gulp.task('js-min', function () {
  gulp.src(['./resources/assets/js/*.js'])
    .pipe(uglify({preserveComments: 'some', mangle: true}))
    .pipe(gulp.dest('./public/app/js'));
});

gulp.task('phplint', function(cb) {
  phplint(['app/**/*.php','database/**/*.php'], {limit: 10}, function (err, stdout, stderr) {
    if (err) {
      cb(err);
      process.exit(1);
    }
    cb();
  });
});
