// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  ssr: true,
  nitro: {
    preset: 'static',
  },
  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8888/api'
    }
  },
  css: [
    '@/assets/css/tailwind.css'
  ],
  modules: [
    '@nuxtjs/tailwindcss',
  ]
})
