import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref<{
    id: string
    name: string
    email: string
    avatar?: string
  } | null>(null)
  
  const token = ref<string | null>(null)
  const isAuthenticated = computed(() => !!user.value)

  function login(credentials: { email: string, password: string }) {
    // In a real app, you would call your API here
    return new Promise<void>((resolve) => {
      setTimeout(() => {
        user.value = {
          id: '1',
          name: 'John Doe',
          email: credentials.email,
          avatar: 'https://cdn.vuetifyjs.com/images/john.jpg'
        }
        token.value = 'fake-jwt-token'
        resolve()
      }, 500)
    })
  }

  function logout() {
    user.value = null
    token.value = null
  }

  return {
    user,
    token,
    isAuthenticated,
    login,
    logout
  }
})