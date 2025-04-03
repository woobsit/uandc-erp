// import this after install `@mdi/font` package
import '@mdi/font/css/materialdesignicons.css'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import {usePreferencesStore}  from '~/stores/preferences.ts';

export default defineNuxtPlugin((app) => {

  const preferences = usePreferencesStore()

  const vuetify = createVuetify({
    theme: {
      defaultTheme: preferences.darkMode ? 'dark' : 'light',
      themes: {
        light: {
          colors: {
            primary: '#1867C0',
            secondary: '#5CBBF6',
          }
        },
        dark: {
          colors: {
            primary: '#2196F3',
            secondary: '#424242',
          }
        }
      }}
  })
  app.vueApp.use(vuetify)
})
