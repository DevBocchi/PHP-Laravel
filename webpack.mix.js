const mix = require('laravel-mix');

mix
    .sass('resources/css/app.css', 'public/css')
    .js('resources/js/app.js', 'public/js');
