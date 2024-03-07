import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import collectModuleAssetsPaths from './vite-module-loader.js';
import vue from '@vitejs/plugin-vue';

async function getConfig() {
    const paths = [
        'resources/css/app.css',
        'resources/js/app.js',
        // 'Modules/Settings/resources/assets/sass/app.scss',
        // 'Modules/Settings/resources/assets/js/app.js',
    ];
    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');
    console.log(allPaths)
    return defineConfig({
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        resolve: {
            alias: {
                vue: 'vue/dist/vue.esm-bundler.js',
            },
        },
    });
}
export default getConfig();
