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
mix.copyDirectory('resources/js/register', 'public/js/register');
mix.copyDirectory('resources/js/students', 'public/js/students');
mix.copyDirectory('resources/js/export', 'public/js/export');
mix.copyDirectory('resources/js/admin', 'public/js/admin');
