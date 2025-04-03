// stores/preferences.ts
import { defineStore } from 'pinia'
import { ref, watch } from 'vue'
import { useVuetify } from 'vuetify'

export const usePreferencesStore = defineStore('preferences', () => {
  // Initialize with localStorage value or default to false
  const darkMode = ref(process.client ? localStorage.getItem('darkMode') === 'true' : false)
  
  // Toggle function with persistence
  function toggleDarkMode() {
    darkMode.value = !darkMode.value
    if (process.client) {
      localStorage.setItem('darkMode', String(darkMode.value))
    }
  }

  // Watch for changes to apply theme
  if (process.client) {
    watch(
      () => darkMode.value,
      (newVal) => {
        const vuetify = useVuetify()
        if (vuetify) {
          vuetify.theme.global.name.value = newVal ? 'dark' : 'light'
        }
        
        // For Tailwind dark mode support (optional)
        document.documentElement.classList.toggle('dark', newVal)
        
        // For custom CSS variables
        document.documentElement.style.setProperty(
          '--background-color', 
          newVal ? '#1a1a1a' : '#ffffff'
        )
      },
      { immediate: true }
    )
  }

  return { 
    darkMode,
    toggleDarkMode
  }
})