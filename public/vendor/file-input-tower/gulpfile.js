/// <binding ProjectOpened='sass-watch' />
/*
This file is the main entry point for defining Gulp tasks and using Gulp plugins.
Click here to learn more. https://go.microsoft.com/fwlink/?LinkId=518007
*/

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    cleanCss = require('gulp-clean-css'),
    terser = require('gulp-terser'),
    rename = require('gulp-rename');

var options = {
    js: {
        src: 'src/tower-file-input.js',
        dest: 'dist'
    },
    css: {
        src: 'src/tower-file-input.scss',
        dest: 'dist'
    }
};

gulp.task('process-sass', function () {
    return gulp.src(options.css.src)
        .pipe(sass())
        .pipe(gulp.dest(options.css.dest))
        .pipe(rename({ suffix: '.min' }))
        .pipe(cleanCss())
        .pipe(gulp.dest(options.css.dest));
});

gulp.task('process-js', function () {
    return gulp.src(options.js.src)
        .pipe(gulp.dest(options.js.dest))
        .pipe(terser())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(options.js.dest));
});

gulp.task('sass-watch', function () {
    return gulp.watch(options.css.src, gulp.parallel('process-sass'));
});

gulp.task('default', gulp.parallel('process-sass', 'process-js'));