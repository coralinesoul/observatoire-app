const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/filter.js', 'public/js')
//  .sass('resources/sass/app.scss', 'public/css')