var gulp = require('gulp');

gulp.task('release', function () {
  return gulp.src(
       [ './*.php', './js/**/*', 'readme.txt' ],
       { base: './' }
  ).pipe( gulp.dest( './dist' ) )
})
