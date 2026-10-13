import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import { google, local } from 'laravel-vite-plugin/fonts';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css'],
            refresh: true,
            fonts: [
                // Variable files keep the opsz axis, so large headings get
                // the high-contrast display cut of the logo monogram.
                local('Bodoni Moda', {
                    alias: 'display',
                    variable: '--font-bodoni-moda',
                    variants: [
                        { src: 'resources/fonts/bodoni-moda/BodoniModa-Variable.woff2', weight: '400 700', style: 'normal' },
                        { src: 'resources/fonts/bodoni-moda/BodoniModa-Italic-Variable.woff2', weight: '400 700', style: 'italic' },
                    ],
                    fallbacks: ['Georgia', 'serif'],
                    preload: [{ weight: '400 700', style: 'normal' }],
                }),
                google('Figtree', {
                    alias: 'sans',
                    variable: '--font-figtree',
                    weights: [400, 500, 600],
                    fallbacks: ['ui-sans-serif', 'system-ui', 'sans-serif'],
                }),
                // Text serif for long-form reading on the articles.
                google('Source Serif 4', {
                    alias: 'serif',
                    variable: '--font-source-serif',
                    weights: [400, 600],
                    styles: ['normal', 'italic'],
                    fallbacks: ['Georgia', 'serif'],
                    preload: false,
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
