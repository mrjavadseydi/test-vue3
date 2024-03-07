// import {defineConfig} from 'vite';
// import laravel from 'laravel-vite-plugin';
// import vue from '@vitejs/plugin-vue';
//
// export default defineConfig({
//     build: {
//         outDir: '../../public/build-settings',
//         emptyOutDir: true,
//         manifest: true,
//     },
//     plugins: [
//         laravel({
//             publicDirectory: '../../public',
//             buildDirectory: 'build-settings',
//             input: [
//                 __dirname + '/resources/assets/sass/app.scss',
//                 __dirname + '/resources/assets/js/app.js'
//             ],
//             refresh: true,
//         }),
//         vue({
//             template: {
//                 transformAssetUrls: {
//                     base: null,
//
//                     includeAbsolute: false,
//                 },
//             },
//         }),
//     ],
//     resolve: {
//         alias: {
//             vue: 'vue/dist/vue.esm-bundler.js',
//         },
//     },
// });

export const paths = [
    'Modules/Settings/resources/assets/sass/app.scss',
    'Modules/Settings/resources/assets/js/app.js',
];
