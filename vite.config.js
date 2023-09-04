import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel([
      'resources/sass/app.scss',
      'resources/sass/admin.scss',
      'resources/js/app.js',
      'resources/js/admin.js'
    ])
  ]
})
