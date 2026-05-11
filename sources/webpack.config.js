import path from 'path';
import TerserPlugin from 'terser-webpack-plugin';
import { globSync } from 'glob';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

class GlobEntryPlugin {
  constructor(patterns, getEntryName) {
    this.patterns = patterns;
    this.getEntryName = getEntryName;
    this.started = false;
  }

  apply(compiler) {
    const { EntryPlugin } = compiler.webpack;

    compiler.hooks.thisCompilation.tap('GlobEntryPlugin', (compilation, { normalModuleFactory }) => {
      const dummy = EntryPlugin.createDependency('./dummy', { name: '__dummy__' });
      compilation.dependencyFactories.set(dummy.constructor, normalModuleFactory);
    });

    compiler.hooks.make.tapAsync('GlobEntryPlugin', (compilation, callback) => {
      const files = this.patterns.flatMap((p) => globSync(p)).map((f) => f.replace(/\\/g, '/'));

      const entries = files.map((f) => ({ file: f, name: this.getEntryName(f) })).filter((e) => e.name);

      Promise.all(
        entries.map(
          ({ file, name }) =>
            new Promise((resolve, reject) => {
              const dep = EntryPlugin.createDependency('./' + file, { name });
              compilation.addEntry(compiler.context, dep, { name }, (err) => (err ? reject(err) : resolve()));
            })
        )
      )
        .then(() => callback())
        .catch(callback);
    });

    compiler.hooks.afterEmit.tap('GlobEntryPlugin', () => {
      if (this.started) return;
      if (!compiler.watching) return;

      this.started = true;

      import('chokidar').then(({ default: chokidar }) => {
        chokidar
          .watch(this.patterns, { ignoreInitial: true })
          .on('add', (f) => {
            console.log('[GlobEntry] + Added:', f);
            compiler.watching?.invalidate();
          })
          .on('unlink', (f) => {
            console.log('[GlobEntry] - Removed:', f);
            compiler.watching?.invalidate();
          });
      });
    });
  }
}

export default (env, argv) => {
  const isDev = argv.mode !== 'production';

  const config = {
    mode: argv.mode,
    entry: {},
    output: {
      filename: '[name]',
      path: path.resolve(__dirname, '../'),
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env'],
            },
          },
        },
      ],
    },
    plugins: [
      new GlobEntryPlugin(['./js/*.js', './blocks/**/*.js'], (filePath) => {
        if (filePath.startsWith('js/')) {
          return path.join('assets', filePath);
        }
        if (filePath.startsWith('blocks/') && !filePath.includes('__example')) {
          return filePath;
        }
        return null;
      }),
    ],
  };

  if (!isDev) {
    config.optimization = {
      minimize: true,
      minimizer: [
        new TerserPlugin({
          terserOptions: {
            ecma: 5,
            format: { comments: false },
          },
          extractComments: false,
        }),
      ],
    };
    config.performance = { hints: false };
  } else {
    config.watch = true;
    config.cache = { type: 'filesystem' };
  }

  return config;
};
