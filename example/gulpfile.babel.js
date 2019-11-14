import path from 'path';
import gulp from 'gulp';
import log from 'fancy-log';
import postcss from './gulp/postcss';

gulp.task('default', () => {
  const src = path.join(__dirname, process.env.MUSTACHE_CSS_DIR);
  log(`Watching ${src.replace(__dirname, '')}...`);
  const watchers = [gulp.watch([path.join(src, '**/*.scss'), `!.css-modules`], postcss)];

  watchers.forEach(watcher => {
    watcher.on('change', event => {
      log(`File ${event.path.replace(__dirname, '')} was ${event.type}, running tasks...`);
    });
  });

  return Promise.all(watchers);
});
