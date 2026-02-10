import gulp from "gulp";
import { deleteAsync } from "del";
import browserify from "browserify";
import babelify from "babelify";
import source from "vinyl-source-stream";
import buffer from "vinyl-buffer";
import sourcemaps from "gulp-sourcemaps";
import uglify from "gulp-uglify";
import rename from "gulp-rename";
import gulpSass from "gulp-sass";
import * as dartSass from "sass";
import sassGlob from "gulp-sass-glob";
import autoprefixer from "gulp-autoprefixer";
import imagemin from "gulp-imagemin";
import minimist from "minimist";
import through2 from "through2";

const sass = gulpSass(dartSass);
// const browserSync = browserSyncLib.create();

// Options / Environment
const argv = minimist(process.argv.slice(2));
const isProd = argv.environment === "production";

// Paths
const srcDir = "./assets";
const destDir = "./source/assets";
const paths = {
  jsMain: `${srcDir}/js/main.js`,
  jsLoader: `${srcDir}/js/elife-loader.js`,
  jsDest: `${destDir}/js`,
  sassMain: `${srcDir}/sass/build.scss`,
  cssDest: `${destDir}/css`,
  imgSrc: `${srcDir}/img/**/*`,
  imgDest: `${destDir}/img`,
  fontsSrc: `${srcDir}/fonts/**/*`,
  fontsDest: `${destDir}/fonts`,
  preloadSrc: `${srcDir}/preload.json`,
  preloadDest: `${destDir}/preload.json`,
};

/*************************************
 * Tasks
 *************************************/

// 1. CSS Task
export const generateCss = async () => {
  await deleteAsync([`${paths.cssDest}/*`]);
  return gulp
    .src(paths.sassMain)
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(
      sass({
        style: isProd ? "compressed" : "expanded",
      }).on("error", sass.logError),
    )
    .pipe(autoprefixer())
    .pipe(rename("all.css"))
    .pipe(sourcemaps.write("./"))
    .pipe(gulp.dest(paths.cssDest));
  // .pipe(browserSync.stream())
};

// 2. JS Task
export const js = async () => {
  // Simple copy for the loader file
  gulp.src(paths.jsLoader).pipe(gulp.dest(paths.jsDest));

  return browserify(paths.jsMain, { debug: true })
    .transform(babelify, { presets: ["@babel/preset-env"] })
    .bundle()
    .on("error", function (err) {
      console.error(err.message);
      this.emit("end");
    })
    .pipe(source("main.js"))
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(isProd ? uglify() : through2.obj())
    .pipe(sourcemaps.write("./"))
    .pipe(gulp.dest(paths.jsDest));
  // .pipe(browserSync.stream())
};

// 3. Image Task
export const images = () => {
  return gulp
    .src(paths.imgSrc, { encoding: false })
    .pipe(imagemin())
    .pipe(gulp.dest(paths.imgDest));
};

// 4. Fonts Task
export const fonts = async () => {
  await deleteAsync([`${paths.fontsDest}/*`]);
  return gulp.src(paths.fontsSrc).pipe(gulp.dest(paths.fontsDest));
};

// 5. preload
export const preload = async () => {
  gulp.src(paths.preloadSrc).pipe(gulp.dest(destDir));
};

// Watch Task
export const watch = () => {
  gulp.watch("assets/sass/**/*", generateCss);
  gulp.watch("assets/js/**/*", js);
  gulp.watch("assets/img/**/*", images);
  gulp.watch("assets/fonts/**/*", fonts);
  gulp.watch("assets/preload.json", preload);
};

// Legacy pattern unit tests
export const test = async () => {
  return gulp.src(`./test/*.html`).pipe(
    through2.obj(function (file, _, cb) {
      console.log(file.path);
      cb(null, file);
    }),
  );
};

// Build / Default
export const build = gulp.series(
  gulp.parallel(generateCss, js, images, fonts, preload),
);

export default build;
