import gulp from 'gulp';
import { deleteAsync } from 'del';
import browserify from 'browserify';
import babelify from 'babelify';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';
import rename from 'gulp-rename';
import gulpSass from 'gulp-sass';
import * as dartSass from 'sass';
import sassGlob from 'gulp-sass-glob';
import autoprefixer from 'gulp-autoprefixer';
import imagemin from 'gulp-imagemin';
import minimist from 'minimist';
import through2 from 'through2';

const sass = gulpSass(dartSass);
// const browserSync = browserSyncLib.create();

// Options / Environment
const argv = minimist(process.argv.slice(2));
const isProd = argv.environment === 'production';

// Paths
const paths = {
  jsMain: './assets/js/main.js',
  jsLoader: './assets/js/elife-loader.js',
  jsDest: './source/assets/js',
  sassMain: './assets/sass/build.scss',
  cssDest: './source/assets/css',
  imgSrc: './assets/img/**/*',
  imgDest: './source/assets/img',
  fontsSrc: './assets/fonts/**/*',
  fontsDest: './source/assets/fonts'
};

/*************************************
 * Tasks
 *************************************/

// 1. CSS Task
export const generateCss = async () => {
  await deleteAsync([`${paths.cssDest}/*`]);
  return gulp.src(paths.sassMain)
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass({ outputStyle: isProd ? 'compressed' : 'expanded' }).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(rename('all.css'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.cssDest))
    // .pipe(browserSync.stream())
    ;
};

// 2. JS Task
export const js = async () => {
  // Simple copy for the loader file
  gulp.src(paths.jsLoader).pipe(gulp.dest(paths.jsDest));

  return browserify(paths.jsMain, { debug: true })
    .transform(babelify, { presets: ['@babel/preset-env'] })
    .bundle()
    .on('error', function(err) {
      console.error(err.message);
      this.emit('end');
    })
    .pipe(source('main.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadMaps: true }))
    // Use gulp-if instead of the ternary operator
    .pipe(isProd ? uglify() : through2.obj())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.jsDest))
    // .pipe(browserSync.stream())
    ;
};

// 3. Image Task
export const images = () => {
  return gulp.src(paths.imgSrc)
    .pipe(imagemin())
    .pipe(gulp.dest(paths.imgDest));
};

// 4. Fonts Task
export const fonts = async () => {
  await deleteAsync([`${paths.fontsDest}/*`]);
  return gulp.src(paths.fontsSrc)
    .pipe(gulp.dest(paths.fontsDest));
};

// Watch Task
export const watch = () => {
  gulp.watch('assets/sass/**/*', generateCss);
  gulp.watch('assets/js/**/*', js);
  gulp.watch('assets/img/**/*', images);
  gulp.watch('assets/fonts/**/*', fonts);
};

// Build / Default
const build = gulp.series(
  gulp.parallel(generateCss, js, images, fonts)
);

export default build;
