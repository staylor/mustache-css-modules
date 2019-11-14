import path from 'path';
import gulp from 'gulp';
import log from 'fancy-log';
import postcss from './gulp/postcss';

gulp.task('default', () => {
  const src = process.env.MUSTACHE_CSS_DIR;

  const watchers = [gulp.watch([path.join(src, '**/*.scss')], postcss)];

  watchers.forEach(watcher => {
    watcher.on('change', event => {
      log(`File ${event.path.replace(__dirname, '')} was ${event.type}, running tasks...`);
    });
  });

  return Promise.all(watchers);
});
