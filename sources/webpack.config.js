const path                  = require('path');
const TerserPlugin          = require('terser-webpack-plugin');
const {CleanWebpackPlugin}  = require('clean-webpack-plugin');
const glob = require('glob');

module.exports = (production) => {
    const entry = {
        script: './js/script.js'
    };

    const blockFiles = glob.sync('./blocks/**/*.js');
    blockFiles.forEach((file) => {
        if (!file.includes('__example')) {
            const entryName = path.relative('./blocks', file);
            entry[entryName] = './' + file;
        }
    });

    let config = {
        mode: production ? "production" : "development",
        entry: entry,
        output: {
            filename: (pathData) => {
                if (pathData.chunk.name === 'script') {
                    return 'script.js';
                } else {
                    const blockPath = path.dirname(pathData.chunk.name); // Получаем путь блока из имени entry
                    const blockName = path.basename(pathData.chunk.name); // Получаем имя блока из имени entry
                    return path.join('../..', 'blocks', blockPath, blockName); // Сохраняем в '../blocks/{blockPath}/{blockName}'
                }
            },
            path: path.resolve(__dirname, '../assets/js')
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }
            ]
        }
    }
    if (production) {
        config.optimization = {
            minimize: true,
            minimizer: [
                new TerserPlugin({
                    terserOptions: {
                        ecma: 5,
                        format: {
                            comments: false
                        }
                    },
                    extractComments: false
                })
            ]
        }
        config.plugins = [new CleanWebpackPlugin()]
        config.performance = {
            hints: false
        }
    }

    return config;
}
