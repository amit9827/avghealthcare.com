import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

 import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(), // Correct usage of the Vue plugin

        VitePWA({
            registerType: 'autoUpdate',
            devOptions: { enabled: true },
            manifest: {
              name: "Avg Healthcare App",
              short_name: "VueLaravel",
              start_url: "/",
              display: "standalone",
              background_color: "#ffffff",
              theme_color: "#4DBA87",
              icons: [
                {
                  src: "pwa-192x192.png",
                  sizes: "192x192",
                  type: "image/png"
                },
                {
                  src: "pwa-512x512.png",
                  sizes: "512x512",
                  type: "image/png"
                }
              ]
            },
            workbox: {
                runtimeCaching: [
                  {
                    // Matches http or https, any domain, and /api/* endpoints
                    urlPattern: /^https?:\/\/.*\/api\/.*$/,
                    handler: "NetworkFirst",
                    options: {
                      cacheName: "api-cache",
                      networkTimeoutSeconds: 5,
                      expiration: {
                        maxEntries: 50,
                        maxAgeSeconds: 60 * 60 // 1 hour
                      },
                      cacheableResponse: {
                        statuses: [0, 200] // only cache successful responses
                      }
                    }
                  },
                  {
                    // Matches images (any domain)
                    urlPattern: /^https?:\/\/.*\.(?:png|jpg|jpeg|svg|gif|webp)$/,
                    handler: "CacheFirst",
                    options: {
                      cacheName: "image-cache",
                      expiration: {
                        maxEntries: 100,
                        maxAgeSeconds: 60 * 60 * 24 * 30 // 30 days
                      },
                      cacheableResponse: {
                        statuses: [0, 200]
                      }
                    }
                  }
                ]
              }

          })

        //ends
    ],
});
