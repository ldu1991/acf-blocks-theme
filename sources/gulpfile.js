'use strict';

const browserSync    = require('browser-sync').create(),
      fs             = require('fs'),
      webpack        = require('webpack-stream'),
      gulp           = require('gulp'),
      sass           = require('gulp-sass')(require('sass')),
      plumber        = require('gulp-plumber'),
      gulpIf         = require('gulp-if'),
      insert         = require('gulp-insert'),
      sourcemaps     = require('gulp-sourcemaps'),
      autoprefixer   = require('gulp-autoprefixer'),
      changedInPlace = require('gulp-changed-in-place'),
      csso           = require('gulp-csso'),
      webpackConfig  = require('./webpack.config.js');

// https://sass-lang.com/documentation/breaking-changes/slash-div

/* Paths and variables */
let domain = 'damp-specialist';

/* End Paths and variables */

function onError(e) {
    console.log(e.toString());
    this.emit('end');
}

/* CSS */
function scss(cb) {
    gulp.src('./scss/**/[^_]*.scss', {allowEmpty: true})
        .pipe(plumber({errorHandler: onError}))
        .pipe(sourcemaps.init())
        .pipe(sass.sync({includePaths: ['./scss/'], silenceDeprecations: ['legacy-js-api']}))
        .pipe(autoprefixer())
        .pipe(changedInPlace({firstPass: true}))
        .pipe(csso())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('../assets/css'));
    cb();
}

function scssRelease(cb) {
    gulp.src('./scss/**/[^_]*.scss', {allowEmpty: true})
        .pipe(plumber({errorHandler: onError}))
        .pipe(sass.sync({includePaths: ['./scss/'], silenceDeprecations: ['legacy-js-api']}))
        .pipe(autoprefixer())
        .pipe(changedInPlace({firstPass: true}))
        .pipe(csso())
        .pipe(gulp.dest('../assets/css'));
    cb();
}

/* End CSS */


/* JS */
function js() {
    return webpack(webpackConfig(false)).pipe(gulp.dest('../assets/js'));
}

function jsRelease() {
    return webpack(webpackConfig(true)).pipe(gulp.dest('../assets/js'));
}

/* End JS */

function browserSyncInit(cb) {
    browserSync.init({
        proxy:  domain,
        notify: false,
        port:   9000
    })

    gulp.watch([
        '../**/*.php',
        '../assets/css/**/*.css',
        '../blocks/**/*.css',
        '../assets/js/**/*.js',
        '../blocks/**/*.js'
    ], {cwd: './'})
        .on('change', function (path, stats) {
            browserSync.reload();
        });
    cb();
}

function watch(cb) {
    gulp.watch('../theme.json', {cwd: './'}, gulp.series(scss, js));
    gulp.watch('./scss/**/*.scss', {cwd: './'}, gulp.series(scss));
    gulp.watch(['./js/**/*.js', './blocks/**/*.js'], {cwd: './'}, gulp.series(js));
    cb();
}


exports.release = gulp.series(scssRelease, jsRelease);
exports.default = gulp.series(scss, js, gulp.parallel(browserSyncInit, watch));
