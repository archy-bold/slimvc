var del = require("del"),
	gulp = require('gulp'),
	sass = require('gulp-sass'),
	watch = require('gulp-watch'),
	uglify = require('gulp-uglify'),
	concat = require('gulp-concat'),
	svgSprite = require('gulp-svg-sprite'),
	svg2png = require('gulp-svg2png'),
	filter = require('gulp-filter'),
	imagemin = require('gulp-imagemin'),
	imageresize = require('gulp-image-resize'),
	rename = require('gulp-rename'),
	spritesmith = require('gulp.spritesmith');

var config = require('./project.json');


gulp.task('css', function() {
	return gulp.src(config.resources.scss + '/*.scss')
		.pipe(sass({
			includePaths: [
				// config.bootstrapDir + '/assets/stylesheets',
			],
		}))
		.pipe(gulp.dest(config.build.css));
});


gulp.task('svg', ['cleanup:svg'], function() {
	var svgConfig = {
		mode: {
			view: {
				dest: '.',
				sprite: 'svg-sprite.svg',
				render: {
					scss: {
						template: config.resources.scss + '/sprites/svg.sass.mustache',
						dest: '../../../' + config.resources.scss + '/sprites/_svg-sprites.scss'
					}
				},
				example: true
			}
		},
		variables: {
			png: function() {
				return function(sprite, render) {
					return render(sprite).split('.svg').join('.png');
				};
			}
		}
	};

	return gulp.src(config.resources.sprites + '/svg/*.svg')
		.pipe(svgSprite(svgConfig))
		.pipe(gulp.dest(config.build.sprites))
		.pipe(filter("**/*.svg"))
		.pipe(svg2png())
		.pipe(imagemin())
		.pipe(gulp.dest(config.build.sprites));
});


gulp.task('png', ['png:retina', 'png:sprites']);

gulp.task('png:retina', function() {

	// Generate half sizes from retina sprites
	return gulp.src(config.resources.sprites + 'source-2x/*.png')
		.pipe(imageresize({
			width: '50%'
		}))
		.pipe(rename(function (path) { path.basename = path.basename.replace('@2x', ''); }))
		.pipe(gulp.dest(config.resources.sprites + 'source'));
});

gulp.task('png:sprites', ['png:retina', 'cleanup:png'], function(cb) {

	var timestamp = Date.now();

	var spriteData = gulp.src(config.resources.sprites + 'source/*.png')
		.pipe(spritesmith({
			imgName: 'sprite-' + timestamp + '.png',
			cssName: '_sprite.scss',
			cssTemplate: config.resources.scss + 'utilities/sprites.styl.mustache',
			cssVarMap: function(sprite) {
				sprite.imagenx = sprite.image.replace('.png', '');
				sprite.name = 'sprite__' + sprite.name;
			},
			padding: 20
		}));

	spriteData.img
		.pipe(imagemin())
		.pipe(gulp.dest(config.resources.sprites));
	
	spriteData.css.pipe(gulp.dest(config.resources.scss + 'utilities/sprites/'));

	var retinaSpriteData = gulp.src(config.resources.sprites + 'source-2x/*.png')
		.pipe(spritesmith({
			imgName: 'sprite-2x-' + timestamp + '.png',
			cssName: '_sprite-2x.scss',
			cssTemplate: config.resources.scss + 'utilities/sprites.styl.mustache',
			cssVarMap: function(sprite) {
				// sprite.imagenx = sprite.image.replace('.png', '');
				sprite.name = 'sprite-2x__' + sprite.name;
			},
			padding: 40
		}));

	retinaSpriteData.img
		.pipe(imagemin())
		.pipe(gulp.dest(config.resources.sprites));

	retinaSpriteData.css.pipe(gulp.dest(config.resources.scss + 'utilities/sprites/'));

	cb();

});


/* JAVASCRIP TASKS */
gulp.task('js-app', function() {
	return gulp.src(config.resources.js + '/app.js')
		.pipe(gulp.dest(config.build.js));
});

gulp.task('js-dependencies', function() {
	return gulp.src(config.dependencies)
		.pipe(concat('dependencies.js'))
		.pipe(gulp.dest(config.build.js));
});

gulp.task('js-uglify-app', function() {
	return gulp.src(config.build.js + '/app.js')
		.pipe(concat('app.min.js'))
		.pipe(uglify({compress:false}))
		.pipe(concat('app.min.js'))
		.pipe(gulp.dest(config.build.js));
});

gulp.task('js-uglify-dependencies', function() {
	return gulp.src(config.build.js + '/dependencies.js')
		.pipe(concat('dependencies.min.js'))
		.pipe(uglify({compress:false}))
		.pipe(concat('dependencies.min.js'))
		.pipe(gulp.dest(config.build.js));
});
/* END JAVASCRIPT TASKS */


/* CLEANUP TAKS */
gulp.task('cleanup:svg', function(cb) {
	del([
		config.build.sprites + '/svg-sprite-*'
	], cb);
});

gulp.task('cleanup:png', function(cb) {
	del([
		config.resources.sprites + 'sprite-*.png'
	], cb);
});
/* END CLEANUP TAKS */


/* WATCH AND BUILD TASKS */
gulp.task('default', ['build'], function() {
	gulp.start('watch');
});

gulp.task('watch', function() {
	watch(config.resources.sprites + '/svg/**/*.svg', function(files) {gulp.start('svg');});
	watch(config.resources.sprites + '/source-2x/*', function(files) {gulp.start('png');});
	watch(config.resources.scss + '/**/*.scss', function(files) {gulp.start('css');});
	watch(config.resources.js + '/**/*.js', function(files) {gulp.start('build:js');});
});

gulp.task('build:css', ['svg', 'png'], function() {
	gulp.start('css');
});

gulp.task('build:js', ['js-dependencies', 'js-app'], function() {
	gulp.start('js-uglify-dependencies');
	gulp.start('js-uglify-app');
});

gulp.task('build', ['build:css', 'build:js']);

function handleError(err) {
    console.log(err.toString());
    this.emit('end');
}
