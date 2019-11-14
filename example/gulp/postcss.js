import path from 'path';
import gulp from 'gulp';
import postcss from 'gulp-postcss';
import rename from 'gulp-rename';
import plumber from 'gulp-plumber';

const cssDir = process.env.MUSTACHE_CSS_DIR;
const SRC = path.join(cssDir, '**/*.scss');
const DEST = path.join(cssDir, '.css-modules');

function compile() {
  return new Promise((resolve, reject) => {
    gulp
      .src(SRC)
      .pipe(plumber())
      .pipe(postcss())
      .pipe(rename({ extname: '.css' }))
      .pipe(gulp.dest(DEST))
      .on('finish', () => {
        resolve();
      });
  });
}

export default () => compile();
