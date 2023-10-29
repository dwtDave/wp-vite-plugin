import { defineConfig } from 'vite';

export default defineConfig({
    server: {
        cors: true,
        strictPort: true,
        port: 3000,
        hmr: {
            port: 3000,
            host: 'localhost',
            protocol: 'ws',
        },
    },
    build: {
        outDir: 'assets/dist',
        assetsDir: '.',
        manifest: true,
        rollupOptions: {
            input: {
                main: 'assets/src/js/main.js',
            },
        },
    },
    plugins: [
        {
          name: "php",
          handleHotUpdate({ file, server }) {
            if (file.endsWith(".php")) {
              server.ws.send({ type: "full-reload", path: "*" });
            }
          },
        },
      ],
});
