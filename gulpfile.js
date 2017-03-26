var gulp = require('gulp');

gulp.task('release', function () {
  return gulp.src(
       [ './*.php', './js/**/*' ],
       { base: './' }
  ).pipe( gulp.dest( './awesome-google-suggestions' ) )
})
