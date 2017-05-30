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
    [ 'resources/assets/images/guide', 'images/guide', false],
    ['node_modules/font-awesome/css', 'font-awesome', false],
    ['resources/assets/js/web', 'js/web', false],
    ['node_modules/jquery-datetimepicker/build/jquery.datetimepicker.min.css', 'admin/css/jquery-datetimepicker', false],
    ['node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js', 'admin/js/jquery-datetimepicker', false],
    ['resources/assets/sass/admin/banner.css', 'admin/css', false],
    ['node_modules/fancybox/dist', 'fancybox', false],
];

for (var i = 0; i < assetsCopy.length; i++) {
    mix.copy(assetsCopy[i][0], assetPath + assetsCopy[i][1], assetsCopy[i][2]);
}

mix.js('resources/assets/js/app.js', assetPath + 'js')
    .js('resources/assets/js/admin/admin.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/article.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/banner.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/tag.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/recommend_article.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/popular_article.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/category.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/article_rank.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/menu.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/survey.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/question.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/omikuji.js', assetPath + 'admin/js')
    .sass('resources/assets/sass/admin/omikuji.scss', assetPath + 'admin/css')
    .js('resources/assets/js/admin/setting_hot_tags.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/popular_series.js', assetPath + 'admin/js')
    .js('resources/assets/js/admin/coupon.js', assetPath + 'admin/js')
    .sass('resources/assets/sass/admin/article.scss', assetPath + 'admin/css')
    .sass('resources/assets/sass/admin/survey.scss', assetPath + 'admin/css')
    .sass('resources/assets/sass/admin.scss', assetPath + 'admin/css')
    .sass('resources/assets/sass/article.scss', assetPath + 'css')
    .sass('resources/assets/sass/app.scss', assetPath + 'css')
    .sass('resources/assets/sass/admin/coupon.scss', assetPath + 'admin/css')
    .sass('resources/assets/sass/admin/category.scss', assetPath + 'admin/css')
    .js('resources/assets/js/admin/popular_category.js', assetPath + 'admin/js');
