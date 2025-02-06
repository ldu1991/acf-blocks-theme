import path from 'path';
import TerserPlugin from 'terser-webpack-plugin';
import {CleanWebpackPlugin} from 'clean-webpack-plugin';
import { globSync } from 'glob';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default (production) => {
    const entry = {
        script: './js/script.js'
    };

    const blockFiles = globSync('./blocks/**/*.js');
    blockFiles.forEach((file) => {
        if (!file.includes('__example')) {
            const entryName  = path.relative('./blocks', file);
            entry[entryName] = './' + file;
        }
    });

    let config = {
        mode:   production ? "production" : "development",
        entry:  entry,
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
            path:     path.resolve(__dirname, '../assets/js')
        },
        module: {
            rules: [
                {
                    test:    /\.js$/,
                    exclude: /node_modules/,
                    use:     {
                        loader:  'babel-loader',
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
            minimize:  true,
            minimizer: [
                new TerserPlugin({
                    terserOptions:   {
                        ecma:   5,
                        format: {
                            comments: false
                        }
                    },
                    extractComments: false
                })
            ]
        }
        config.plugins      = [new CleanWebpackPlugin()]
        config.performance  = {
            hints: false
        }
    }

    return config;
}
