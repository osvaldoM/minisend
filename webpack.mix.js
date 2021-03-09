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

mix.override(config => {
    const rules = config.module.rules;
    const targetRegex = /(\.(png|jpe?g|gif)$|^((?!font).)*\.svg$)/;

    //add svg as exception to existing rules
    for(let rule of rules){
        if(rule.test.test && rule.test.test('.svg')){
            rule.exclude = /\.svg$/;
        }
    }
    //use asset modules
    config.module.rules.push({
        test: /\.svg/,
        type: 'asset/source',
    });

});

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css', {}, [
        require("tailwindcss"),
    ])
    .sourceMaps();
