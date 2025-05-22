const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/polygon.js', 'public/js') // Agregamos tron-wallet.js
   .sourceMaps();
