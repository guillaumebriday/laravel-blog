import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/sass/app.scss',
        'resources/sass/admin.scss',
        'resources/js/app.js',
        'resources/js/admin.js',
      ],
      refresh: true,
    }),
  ],
  css: {
    preprocessorOptions: {
      scss: {
        // Bootstrap 5 is still written with @import, keep its deprecations quiet
        quietDeps: true,
        silenceDeprecations: ['import'],
      },
    },
  },
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
})
