// See: http://travismaynard.com/writing/getting-started-with-gulp
// Include gulp
var gulp = require('gulp');
var zip = require('gulp-zip');

var VERSION = "1.0.1";

var paths = {
  src_glob: './g11*/**',
  wp_install: '/wp/wp41',
  theme_glob: './themes/**'
};

gulp.task('zip', function () {
    gulp.src('./g11-carousel*/**')
        .pipe(zip('g11-carousel-'+VERSION+'.zip'))
        .pipe(gulp.dest('dist'));
    gulp.src('./g11-is-mobile*/**')
        .pipe(zip('g11-is-mobile-'+VERSION+'.zip'))
        .pipe(gulp.dest('dist'));
    gulp.src('./g11-google-analytics*/**')
        .pipe(zip('g11-google-analytics-'+VERSION+'.zip'))
        .pipe(gulp.dest('dist'));
    gulp.src('./g11-autop*/**')
        .pipe(zip('g11-autop-'+VERSION+'.zip'))
        .pipe(gulp.dest('dist'));
    gulp.src('./g11-open-table*/**')
        .pipe(zip('g11-open-table-'+VERSION+'.zip'))
        .pipe(gulp.dest('dist'));
    gulp.src('./themes/rocksalt*/**')
        .pipe(zip('rocksalt-'+VERSION+'.zip'))
        .pipe(gulp.dest('dist'));
});

gulp.task('local', function () {
    gulp.src(paths.src_glob)
        .pipe(gulp.dest(paths.wp_install + "/wp-content/plugins"));
    gulp.src(paths.theme_glob).pipe(gulp.dest(paths.wp_install + "/wp-content/themes"));
});

// Watch Files For Changes
gulp.task('watch', function() {
    var watcher = gulp.watch(paths.src_glob, ['local']);
    watcher.on('change', function(event) {
  		console.log('File '+event.path+' was '+event.type+', running tasks...');
	});
});

// Default Task
gulp.task('default', ['zip']);

