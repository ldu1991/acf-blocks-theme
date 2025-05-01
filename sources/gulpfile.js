import browserSyncLib from 'browser-sync';
import fs from 'fs';
import gulp from 'gulp';
import sassLib from 'gulp-sass';
import * as dartSass from 'sass';
import plumber from 'gulp-plumber';
import gulpIf from 'gulp-if';
import insert from 'gulp-insert';
import autoprefixer from 'gulp-autoprefixer';
import cached from 'gulp-cached';
import debug from 'gulp-debug';
import dependents from 'gulp-dependents';
import chalk from 'chalk';

const browserSync = browserSyncLib.create();
const sass        = sassLib(dartSass);

// https://sass-lang.com/documentation/breaking-changes/slash-div

/* Paths and variables */
const domain = 'test-template';

/* End Paths and variables */
const onError = err => {
    console.error(err.message);
    //this.emit('end');
};

/* CSS */
const themeData          = JSON.parse(fs.readFileSync('../theme.json'));
let style_editor_default = `body .is-layout-flow {
    > * + * {
        margin-block-start: 0;
        margin-block-end: 0;
    }
    
    > p {
        margin-block-start: ${themeData['styles']['blocks']['core/paragraph']['spacing']['margin']['top']};
        margin-block-end: ${themeData['styles']['blocks']['core/paragraph']['spacing']['margin']['bottom']};
        
        &:last-child {
            margin-block-end: 0;
        }
    }
    
    > p + p {
        margin-block-start: ${themeData['styles']['blocks']['core/paragraph']['spacing']['margin']['top']};
        margin-block-end: ${themeData['styles']['blocks']['core/paragraph']['spacing']['margin']['bottom']};
    }
    
    > h1, > h1 + h1,
    > h2, > h2 + h2,
    > h3, > h3 + h3,
    > h4, > h4 + h4,
    > h5, > h5 + h5,
    > h6, > h6 + h6 {
        margin-block-start: ${themeData['styles']['elements']['heading']['spacing']['margin']['top']};
        margin-block-end: ${themeData['styles']['elements']['heading']['spacing']['margin']['bottom']};
    }
}`;

// Generate Heading
let elements = {
    'heading': '.h1, .h2, .h3, .h4, .h5, .h6',
    'h1':      '.h1',
    'h2':      '.h2',
    'h3':      '.h3',
    'h4':      '.h4',
    'h5':      '.h5',
    'h6':      '.h6'
};

function generateSpacing(json, prefix = '') {
    let css = '';

    for (const key in json) {
        const value = json[key];
        if (value !== '') {
            if (typeof value === 'object') {
                css += generateSpacing(value, `${prefix}${key}-`);
            } else {
                const kebabCaseKey = `${prefix}${key.replace(/([A-Z])/g, '-$1').toLowerCase()}`;
                css += `${kebabCaseKey}: ${value}; `;
            }
        }
    }

    return css;
}

function generateTypography(json) {
    let css = '';

    for (const key in json) {
        const value = json[key];
        if (value) {
            if (key === 'textColumns') {
                css += `column-count: ${value};`;
            } else {
                css += `${key.replace(/([A-Z])/g, '-$1').toLowerCase()}: ${value};`;
            }
        }
    }

    return css;
}

function generateColor(json) {
    let css = '';

    for (const key in json) {
        const value = json[key];
        if (value !== '') {
            if (key === 'gradient') {
                css += 'background:' + value + ';';
            } else if (key === 'background') {
                css += 'background-color:' + value + ';';
            } else if (key === 'text') {
                css += 'color:' + value + ';';
            }
        }
    }

    return css;
}

function generateBorder(json, prefix = '') {
    let css = '';

    for (const key in json) {
        const value = json[key];

        if (typeof value === 'object') {
            css += generateBorder(value, `${prefix}${key}-`);
        } else if (value) {
            const cssProperty  = `${prefix}${key.replace(/([A-Z])/g, '-$1').toLowerCase()}`;
            const propertyName = `border-${cssProperty}`;
            css += `${propertyName}: ${value};\n`;
        }
    }

    return css;
}

function generateOutline(json) {
    let css = '';

    for (const key in json) {
        const value = json[key];
        if (value !== '') {
            css += `outline-${key}: ${value};`;
        }
    }

    return css;
}

function generateDimensions(json) {
    let css = '';

    for (const key in json) {
        const value = json[key];
        if (value !== '') {
            css += `${key.replace(/([A-Z])/g, '-$1').toLowerCase()}: ${value};`;
        }
    }

    return css;
}

let additional_header_classes = '';
for (let elementsKey in elements) {
    let elementValue = themeData.styles.elements[elementsKey];

    if (elementValue !== undefined) {
        additional_header_classes += elements[elementsKey] + '{';
        for (let elementKey in elementValue) {

            if (elementKey === 'spacing') {
                additional_header_classes += generateSpacing(elementValue[elementKey]);
            } else if (elementKey === 'typography') {
                additional_header_classes += generateTypography(elementValue[elementKey]);
            } else if (elementKey === 'color') {
                additional_header_classes += generateColor(elementValue[elementKey]);
            } else if (elementKey === 'border') {
                additional_header_classes += generateBorder(elementValue[elementKey]);
            } else if (elementKey === 'outline') {
                additional_header_classes += generateOutline(elementValue[elementKey]);
            } else if (elementKey === 'dimensions') {
                additional_header_classes += generateDimensions(elementValue[elementKey]);
            } else if (elementKey === 'shadow') {
                additional_header_classes += `box-shadow: ${elementValue[elementKey]};`;
            }
        }

        additional_header_classes += '}';
    }
}

// End Generate Heading

function scss(cb) {
    gulp.src('./scss/**/*.scss', { allowEmpty: true, sourcemaps: true })
        .pipe(plumber({ errorHandler: onError }))
        .pipe(cached('scss'))
        .pipe(dependents())
        .pipe(debug({
            title: '', logger: message => {
                console.log(chalk.green.bold('SCSS compiled:') + message);
            }
        }))
        .pipe(insert.append(additional_header_classes))
        .pipe(sass.sync())
        .pipe(gulpIf(
            file => file.path.endsWith('style-editor.scss'),
            insert.prepend(style_editor_default)
        ))
        .pipe(autoprefixer())
        .pipe(gulp.dest('../assets/css', { sourcemaps: true }));
    cb();
}

function scssRelease(cb) {
    gulp.src('./scss/**/*.scss', { allowEmpty: true })
        .pipe(plumber({ errorHandler: onError }))
        .pipe(insert.append(additional_header_classes))
        .pipe(sass.sync({ style: 'compressed' }))
        .pipe(gulpIf(file => file.path.endsWith('style-editor.scss'), insert.prepend(style_editor_default)))
        .pipe(autoprefixer())
        .pipe(gulp.dest('../assets/css'));
    cb();
}

function scssBlocks(cb) {
    gulp.src(['./blocks/**/*.scss', '!./blocks/__example/**'], { allowEmpty: true, sourcemaps: true })
        .pipe(plumber({ errorHandler: onError }))
        .pipe(cached('scss'))
        .pipe(dependents())
        .pipe(debug({
            title: '', logger: message => {
                console.log(chalk.green.bold('SCSS compiled:') + message);
            }
        }))
        .pipe(sass.sync())
        .pipe(autoprefixer())
        .pipe(gulp.dest('../blocks', { sourcemaps: true }));
    cb();
}

function scssBlocksRelease(cb) {
    gulp.src(['./blocks/**/*.scss', '!./blocks/__example/**'], { allowEmpty: true })
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass.sync({ style: 'compressed' }))
        .pipe(autoprefixer())
        .pipe(gulp.dest('../blocks'));
    cb();
}

/* End CSS */


/* Blocks */
function blocksFiles(cb) {
    gulp.src([
        './blocks/**/block.json',
        './blocks/**/render.php',
        '!./blocks/__example/**'
    ], { allowEmpty: true })
        .pipe(gulp.dest('../blocks'));
    cb();
}

/* End Blocks */

function browserSyncInit(cb) {
    browserSync.init({
        proxy:  domain,
        notify: false,
        port:   9000
    });

    gulp.watch([
        '../**/*.php',
        '../assets/css/**/*.css',
        '../blocks/**/*.css',
        '../assets/js/**/*.js',
        '../blocks/**/*.js'
    ], { cwd: './' })
        .on('change', function(path, stats) {
            browserSync.reload();
        });
    cb();
}

function watch(cb) {
    gulp.watch('../theme.json', gulp.series(scss));
    gulp.watch('./scss/**/*.scss', gulp.series(scss))
        .on('unlink', filepath => {
            delete cached.caches.scss[filepath];
        });
    gulp.watch('./blocks/**/*.scss', gulp.series(scssBlocks))
        .on('unlink', filepath => {
            delete cached.caches.scss[filepath];
        });
    gulp.watch(['./blocks/**/*.json', './blocks/**/*.php'], gulp.series(blocksFiles));
    cb();
}


export const release = gulp.series(scssRelease, scssBlocksRelease);
export default gulp.series(scss, scssBlocks, blocksFiles, gulp.parallel(browserSyncInit, watch));
