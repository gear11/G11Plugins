// See: http://travismaynard.com/writing/getting-started-with-gulp
// Include gulp
var gulp = require('gulp');
var zip = require('gulp-zip');

var VERSION = "1.0.0";

var paths = {
  src_glob: './g11*/**',
  wp_install: '/wp/wp41'
};

gulp.task('zip', function () {
    gulp.src(paths.src_glob)
        .pipe(zip('g11-carousel-'+VERSION+'.zip'))
        .pipe(gulp.dest('dist'));
});

gulp.task('local', function () {
    gulp.src(paths.src_glob)
        .pipe(gulp.dest(paths.wp_install + "/wp-content/plugins"));
});

// Watch Files For Changes
gulp.task('watch', function() {
    var watcher = gulp.watch(paths.src_glob, ['local']);
    watcher.on('change', function(event) {
  		console.log('File '+event.path+' was '+event.type+', running tasks...');
	});
});

// Default Task
gulp.task('default', ['local']);

