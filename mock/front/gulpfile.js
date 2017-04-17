'use strict';

var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var plumber = require('gulp-plumber');
var runSequence = require('run-sequence');
var browserSync = require('browser-sync').create();
var del = require('del');
var fs = require('fs');
var pug = require('pug');
var inject = require('gulp-inject');
var bundle = require('gulp-bundle-assets');
var series = require('stream-series');
var less = require('gulp-less');

var source = 'source/',
  dest = 'dist/';
var fonts = { in: [
    source + 'fonts/**/*.*',
    './node_modules/font-awesome/fonts/*', source + 'fonts-2/**/*'
  ],
  out: dest + 'fonts/'
};
var js = {
  in: source + 'js/**/*.js',
  out: dest + 'js'
};

/**
 * Configurations
 *
 */
pug.filters.code = function (block) {
  return block
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

var options = {
  del: {
    dest: dest,
    js: dest + 'js'
  },
  browserSync: {
    server: {
      baseDir: dest
    },
    startPath: "links.html",
    reloadDelay: 500
  },
  htmlPrettify: {
    'indent_size': 2,
    'unformatted': ['pre', 'code'],
    'indent_with_tabs': false,
    'preserve_newlines': true,
    'brace_style': 'expand',
    'end_with_newline': true
  },
  include: {
    hardFail: true,
    includePaths: [
      __dirname + "/",
      __dirname + "/node_modules",
      __dirname + "/source/js"
    ]
  },
  pug: {
    pug: pug,
    pretty: '\t',
    basedir: './'
  },
  less: {
    paths: [
      './node_modules/'
    ]
  }
}

/**
 * Tasks
 * Allow add filter
 *
 */
gulp.task('browser-sync', function () {
  return browserSync.init(options.browserSync);
});

gulp.task('watch', function (cb) {
  $.watch(source + 'less/**/*.less', function () {
    gulp.start('compile-styles');
  });

  $.watch(source + 'images/**/*', function () {
    gulp.start('compile-images');
    gulp.start('build-images-name');
  });

  $.watch([
    source + '*.html',
    source + '**/*.html'
  ], function () {
    return runSequence('compile-html', browserSync.reload);
  })

  $.watch([
    source + '*.pug',
    source + '**/*.pug'
  ], function () {
    return runSequence('compile-pug', browserSync.reload);
  })

  $.watch(source + '**/*.js', function () {
    return runSequence('copy-js',  browserSync.reload);
  })
});

// IMAGES
gulp.task('compile-images', function () {
  return gulp.src(source + 'images/**/*.*')
    .pipe(gulp.dest(dest + 'images'));
});

// IMAGES - Build images name in json file
gulp.task('build-images-name', function() {
  return gulp.src(source + 'images/**/*')
    .pipe(require('gulp-filelist')('filelist.json'))
    .pipe(gulp.dest('tmp'));
});

// FONTS
gulp.task('fonts', function () {
  return gulp
    .src(fonts.in)
    .pipe(gulp.dest(fonts.out));
});

// CSS - Compile less
gulp.task('compile-styles',function (cb) {
  return gulp.src([
      source + 'less/*.less',
      '!' + source + 'less/_*.less'
    ])
    .pipe($.sourcemaps.init())
    .pipe(less(options.less))
    .pipe($.autoprefixer('last 2 versions'))
    .pipe($.sourcemaps.write('./', {
      includeContent: false,
      sourceRoot: source + 'less'
    }))
    .pipe(gulp.dest(dest + 'css'))
    .pipe(browserSync.stream());
})

// JS - JShint
gulp.task('jshint', function() {
  return gulp.src(js.in)
    .pipe($.jshint())
    .pipe($.jshint.reporter('jshint-stylish'));
});

// JS - Cleanup
gulp.task('cleanup-js', function (cb) {
  return del(options.del.js, cb);
});

// JS - Copy js files
gulp.task('copy-js', ['cleanup-js'],function () {
  gulp.src(js.in)
    .pipe(gulp.dest(js.out));
});

// JS - Bundle js files
gulp.task('bundle-js', ['cleanup-js', 'jshint'],function () {
  gulp.src('./bundle.config.js')
    .pipe(bundle())
    .pipe(gulp.dest(dest + 'js'));
});

// HTML
gulp.task('compile-html', function (cb) {
  return gulp.src(['*.html', '!_*.html'], {
      cwd: 'source'
    })
    .pipe($.prettify(options.htmlPrettify))
    .pipe(gulp.dest(dest));
})

// HTML - Pug
gulp.task('compile-pug', function (cb) {
  var jsonData = JSON.parse(fs.readFileSync('./tmp/data.json'));
  options.pug.locals = jsonData;

  return gulp.src(['*.pug', 'templates/**/*.pug', '!_*.pug'], {cwd: 'source'})
    .pipe(plumber(function(error){
        console.log("Error happend!", error.message);
        this.emit('end');
    }))
    .pipe($.pug(options.pug))
    .on('error', function (error) {
      console.error('' + error);
      this.emit('end');
    })
    .pipe($.prettify(options.htmlPrettify))
    .pipe(gulp.dest(dest));
});

// HTML - Inject css, js
gulp.task('inject', function () {
  var i = 0;
  var template = gulp.src(dest + '*.html')
  var cssSource = gulp.src([dest + 'css/*.css'], {
    read: false
  });
  var vendorStream = gulp.src([dest + 'js/vendor' + '*.js'], {
    read: false
  });
  var mainStream = gulp.src([dest + 'js/main' + '*.js'], {
    read: false
  });

  template.pipe(inject(cssSource, {
      ignorePath: dest
    }))
    .pipe(inject(series(vendorStream, mainStream), {
      ignorePath: dest
    }))
    .pipe(gulp.dest(dest));
});

gulp.task('build-html', function (cb) {
  return runSequence(
    'combine-data',
    'compile-pug',
    'compile-html',
    cb
  );
});

// JSON
// = Build DataJson
gulp.task('combine-modules-json', function(cb) {
  return gulp.src(['**/*.json', '!**/_*.json'], {cwd: 'source/modules/*/data'})
    .pipe($.mergeJson('data-json.json'))
    .pipe(gulp.dest('tmp/data'));
});

gulp.task('combine-modules-data', function(cb) {
  return gulp.src('**/*.json', {cwd: 'tmp/data'})
    .pipe($.mergeJson('data.json'))
    .pipe(gulp.dest('tmp'));
});

// Service tasks
gulp.task('combine-data', function(cb) {
  return runSequence(
    [
      'combine-modules-json'
    ],
    'combine-modules-data',
    cb
  );
});

// DEST - Cleanup
gulp.task('cleanup', function (cb) {
  return del(options.del.dest, cb);
});

// NODE - Setup node environment
gulp.task('set-env:dev', function() {
  return process.env.NODE_ENV = "development";
})

gulp.task('set-env:prod', function() {
  return process.env.NODE_ENV = "production";
})

// ================ Develop
gulp.task('dev', ['set-env:dev'], function (cb) {
  return runSequence(
    'cleanup',
    'fonts',
    'compile-images',
    'compile-styles',
    'copy-js',
    'build-html',
    'browser-sync',
    'build-images-name',
    'watch',
    cb
  );
})

// ================ Build
gulp.task('build', ['set-env:prod'], function (cb) {
  return runSequence(
    'cleanup',
    'fonts',
    'compile-images',
    'compile-styles',
    'copy-js',
    'build-html',
    cb
  );
});
