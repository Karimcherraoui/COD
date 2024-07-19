const mix = require('laravel-mix');
const { VueLoaderPlugin } = require('vue-loader');

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .css('resources/css/app.css', 'public/css')
   .webpackConfig({
       plugins: [
           new VueLoaderPlugin()
       ],
       resolve: {
           extensions: [".*",".wasm",".mjs",".js",".jsx",".json",".vue"]
       }
   });