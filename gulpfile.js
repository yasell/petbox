'use strict';

var gulp = require('gulp');
var server = require('browser-sync');
var plumber = require('gulp-plumber');

var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var mqpacker = require('css-mqpacker');
var csso = require('gulp-csso');

var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var image = require('gulp-image');

// compile sass & css optimization
gulp.task('style', function () {
	return gulp.src("assets/src/app.scss")
		.pipe(plumber())
		.pipe(sass())
		.pipe(postcss([
			autoprefixer({
				browsers: ['last 4 versions']
			}),
			mqpacker({
				sort: true
			})
		]))
		.pipe(gulp.dest('./'))
		.pipe(rename('app.min.css'))
		.pipe(csso({
			restructure: true,
			sourceMap: false,
			debug: false
		}))
		.pipe(gulp.dest("dist/"))
		.pipe(server.reload({
			stream: true
		}));
});

// common js task
gulp.task('script', function () {
	return gulp.src([
			// 'src/js/instafeed.min.js',
			'js/main.js'
		])
		.pipe(concat('app.js'))
		.pipe(gulp.dest('assets/js/'))
		.pipe(rename('app.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('dist/'))
		.pipe(server.reload({
			stream: true
		}));
});

// server (not working now)
gulp.task('serve', ['style'], function () {

	server.init({
		proxy: 'http://petbox.new/',
		notify: false,
		open: true,
		ui: false
	});

	gulp.watch('assets/src/sass/**/*.{scss,sass}', ['style']);
	gulp.watch('src/js/*.js', ['script']);
	gulp.watch("*.php").on('change', server.reload);
});

// image min
gulp.task('img-min', function () {
	gulp.src("images/**/*")
		.pipe(image())
		.pipe(gulp.dest("images/"));
});

// image compress task
gulp.task("compress", ["img-min"]);
