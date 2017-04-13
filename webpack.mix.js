const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
var assetPath = 'public/assets/';
var assetsCopy = [
    ['mock/admin/css', 'admin/css', false],
    ['mock/admin/js', 'admin/js', false],
    ['mock/admin/img', 'admin/img', false],
    ['mock/admin/fonts', 'admin/fonts', false],
    ['mock/admin/font-awesome', 'admin/font-awesome', false],
    ['mock/admin/locales', 'admin/locales', false],
    ['mock/front/dist/js', 'js', false],
    ['mock/front/dist/css', 'css', false],
    ['mock/front/dist/fonts', 'fonts', false],
    ['mock/front/dist/images', 'images', false],
];

for (var i = 0; i < assetsCopy.length; i++) {
    mix.copy(assetsCopy[i][0], assetPath + assetsCopy[i][1], assetsCopy[i][2]);
}

mix.js('resources/assets/js/app.js', assetPath + 'js')
    .sass('resources/assets/sass/app.scss', assetPath + 'css')
    .js('resources/assets/js/admin/admin.js', assetPath + 'admin/js')
    .sass('resources/assets/sass/admin.scss', assetPath + 'admin/css')
;
