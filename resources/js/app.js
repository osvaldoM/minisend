/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./register-filters');

import App from "./components/App";

import Vue from 'vue'

import router from "./router";


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const requireComponent = require.context(
//     // The relative path of the components folder
//     './components/base_components',
//     // Whether or not to look in subfolders
//     false,
//     // The regular expression used to match base component filenames
//     /[A-Z]\w+\.(vue|js)$/
// )
//
// requireComponent.keys().forEach(fileName => {
//     // Get component config
//     const componentConfig = requireComponent(fileName)
//
//     // Get PascalCase name of component
//     const componentName = upperFirst(
//         camelCase(
//             // Gets the file name regardless of folder depth
//             fileName
//                 .split('/')
//                 .pop()
//                 .replace(/\.\w+$/, '')
//         )
//     )
//     // Register component globally
//     Vue.component(
//         componentName,
//         componentConfig.default || componentConfig
//     )
// })


const app = new Vue({
    el: '#app',
    router,
    components: {
        App
    }
});
