import path from 'path';
import TerserPlugin from 'terser-webpack-plugin';
import { CleanWebpackPlugin } from 'clean-webpack-plugin';
import { globSync } from 'glob';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname  = path.dirname(__filename);

export default (env, argv) => {
    let entry = {};

    globSync('./js/*.js').forEach((file) => {
        entry[path.join('assets', file)] = './' + file;
    });

    globSync('./blocks/**/*.js').forEach((file) => {
        if (!file.includes('__example')) {
            entry[file] = './' + file;
        }
    });

    let config = {
        mode:   argv.mode,
        entry:  entry,
        output: {
            filename: '[name]',
            path:     path.resolve(__dirname, '../')
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
    };

    if (argv.mode === 'production') {
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
        };
        config.plugins      = [new CleanWebpackPlugin()];
        config.performance  = {
            hints: false
        };
    } else {
        config.watch = true;
        config.cache = {
            type: 'filesystem'
        };
    }

    return config;
}
