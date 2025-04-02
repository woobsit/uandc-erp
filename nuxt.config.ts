// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: [
    '@nuxtjs/tailwindcss',
    '@pinia/nuxt',
    'nuxt-icon',
    '@nuxt/image'
  ],
  runtimeConfig: {
    public: {
      apiBase: '/api' // Axios base URL
    }
  },
  devtools: { enabled: true },
  compatibilityDate: "2025-03-26",
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  css: ['~/assets/styles/main.css'],
  build: {
    transpile: ['@heroicons/vue']
  }
})