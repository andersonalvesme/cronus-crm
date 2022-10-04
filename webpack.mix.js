const mix = require('laravel-mix');

const WebpackShellPlugin = require('webpack-shell-plugin');
mix.disableNotifications();

mix.webpackConfig({
    module: {
        rules: [{
            test: /\.jsx?$/,
            exclude: /node_modules(?!\/@<redacted>)/,
            use: [{
                loader: 'babel-loader',
                options: Config.babel()
            }]
        }]
    },
    resolve: {
        alias: {
            '@js': path.resolve(
                __dirname,
                'resources/assets/js'
            )
        }
    }
});

mix
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .copy('resources/assets/images/*', 'public/images')
    .copy('resources/assets/icons/*', 'public/icons')
    .webpackConfig({
        plugins:
            [
                new WebpackShellPlugin({onBuildStart: ['docker exec -i app php artisan lang:js'], onBuildEnd: []})
            ]
    })
    .version();
