import { defineConfig } from "vite";
import vue from '@vitejs/plugin-vue'; // Aggiunto import di Vue plugin
import symfonyPlugin from "vite-plugin-symfony";

export default defineConfig({
    plugins: [
        vue(), // Aggiunto Vue plugin
        symfonyPlugin(),
    ],
    build: {
        rollupOptions: {
            input: {
                app: "./assets/app.js"
            },
        }
    },
});

