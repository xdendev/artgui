import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
    plugins: [vue()],
    
    build: {
        outDir: 'stubs',
        emptyOutDir: true,
        manifest: false,
        
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.js'),
            },
            output: {
                // С хешем для версионирования (для cache busting)
                entryFileNames: 'artgui.[hash].js',
                chunkFileNames: 'artgui-[name].[hash].js',
                
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name && assetInfo.name.endsWith('.css')) {
                        return 'artgui.[hash].css';
                    }
                    return 'assets/[name].[hash][extname]';
                },
            },
        },
        
        sourcemap: true,
    },
    
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    },
});
