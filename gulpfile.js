const gulp = require('gulp');
const sass = require('gulp-sass');
const sourceMaps = require('gulp-sourcemaps');
const autoPrefixer = require('gulp-autoprefixer');
const browserSync = require("browser-sync");
const connect = require('gulp-connect-php');
const svgSprite = require('gulp-svg-sprite');

function styles(cb) {
    return gulp.src('./ressources/liaisons/scss/*.scss')
        .pipe(sourceMaps.init())
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(autoPrefixer({
            /*browsers: ['last 2 versions'],*/
            cascade: false
        }))
        .pipe(sourceMaps.write())
        .pipe(gulp.dest('./public/liaisons/css'))
        .pipe(browserSync.stream());
    cb();
}

function watch(cb) {
    connect.server({}, function (){ browserSync( {
        /*  Pour le PHP on utilise un proxy
        *   Remplacer le USER et le NOMPROJET
        *  genre "localhost/~etu01/rpni3/rpni3-crs2/"
        */ proxy: "localhost:8888/traces/public/"
        });
     });
    gulp.watch('./app/**/*.php').on("change",browserSync.reload);
    gulp.watch('./public/*.html').on("change",browserSync.reload);
    gulp.watch('./public/liaisons/js/**/*.js').on("change",browserSync.reload);
    gulp.watch('./ressources/liaisons/scss/**/*.scss', gulp.series('styles'));
    cb();
}

var config = {
    shape: {
        dimension: { // Set maximum dimensions
            maxWidth: 32,
            maxHeight: 32
        },
        spacing: { // Add padding
            padding: 10
        }
    },
    mode: {
        // view: { // Activate the «view» mode
        //     bust: false,
        //     render: {
        //         scss: true // Activate Sass output (with default options)
        //     }
        // },
      // css: true, // Create a «css» sprite
        // view: true, // Create a «view» sprite
        // defs: true, // Create a «defs» sprite
         symbol: true, // Create a «symbol» sprite
        //  stack: true // Create a «stack» sprite
    }
};

function sprite(){
    return gulp.src('./ressources/liaisons/svg/*.svg')
        .pipe(svgSprite(config))
        .pipe(gulp.dest('./public/liaisons'));
}

function defaut(cb){
    console.log("allo");
    // place code for your default task here
    cb();
}

exports.default=defaut;
exports.styles=styles;
exports.watch=watch;
exports.sprite=sprite;