const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/filter.js', 'public/js')
.postCss('resources/css/app.css', 'public/css', [
    tailwindcss('./tailwind.config.js'),
    require('autoprefixer'),
]);
//  .sass('resources/sass/app.scss', 'public/css')