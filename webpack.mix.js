const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/admin_app.js', 'public/admin_assets/app/js/app.js');
mix.sass('resources/sass/admin_app.scss', 'public/admin_assets/app/css/app.css')
    .options({
    processCssUrls: false
});


mix.js('resources/js/LoadComponents/admin/user.js', 'public/admin_assets/custom/js/users/user.js');
mix.js('resources/js/LoadComponents/admin/gallery.js', 'public/admin_assets/custom/js/galleries/gallery.js');
mix.js('resources/js/LoadComponents/admin/country.js', 'public/admin_assets/custom/js/countries/country.js');
mix.js('resources/js/LoadComponents/admin/admin.js', 'public/admin_assets/custom/js/admins/admin.js');
mix.js('resources/js/LoadComponents/admin/category.js', 'public/admin_assets/custom/js/categories/category.js');
