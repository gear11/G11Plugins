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

var lidProjectSpec = {
    "path": "/wp/lid2",
    "plugins": [
        "g11-posts"
    ],
    "themes": [
        "layingitdown"
    ]
};

function generateLocalTaskFunctionFor(projectSpec) {
    var dest = projectSpec.path;
    var plugins = projectSpec.plugins;
    var themes = projectSpec.themes;

    return function() {
        for (var i = 0; i < plugins.length; ++i) {
            gulp.src('./'+plugins[i]+'/**').pipe(gulp.dest(dest + '/wp-content/plugins/' + plugins[i]));
        }
        for (i = 0; i < themes.length; ++i) {
            gulp.src('./themes/'+themes[i]+'/**').pipe(gulp.dest(dest + '/wp-content/themes/' + themes[i]));
        }
    };
}

function generateWatchTaskFunctionFor(projectSpec, tasks) {
    var plugins = projectSpec.plugins;
    var themes = projectSpec.themes;

    onChange = function(event) {
        console.log('File '+event.path+' was '+event.type+', running tasks...');
    };

    return function() {
        for (var i = 0; i < plugins.length; ++i) {
            gulp.watch('./'+plugins[i]+'/**', tasks).on('change', onChange);
        }
        for (i = 0; i < themes.length; ++i) {
            gulp.watch('./themes/'+themes[i]+'/**', tasks).on('change', onChange);
        }
    }
}

gulp.task('lid_local', generateLocalTaskFunctionFor(lidProjectSpec));
gulp.task('lid_watch', generateWatchTaskFunctionFor(lidProjectSpec, ['lid_local']));

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
gulp.task('default', ['lid_watch']);

