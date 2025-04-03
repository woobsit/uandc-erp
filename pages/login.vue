<template>
    <v-container class="fill-height" fluid>
      <v-row justify="center" align="center">
        <v-col cols="12" sm="8" md="6" lg="4">
          <v-card class="elevation-12">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>Logistics Portal Login</v-toolbar-title>
            </v-toolbar>
            
            <v-card-text>
              <v-form @submit.prevent="handleLogin">
                <v-text-field
                  v-model="email"
                  label="Email"
                  name="email"
                  prepend-icon="mdi-email"
                  type="email"
                  required
                  :error-messages="errors.email"
                />
                
                <v-text-field
                  v-model="password"
                  label="Password"
                  name="password"
                  prepend-icon="mdi-lock"
                  type="password"
                  required
                  :error-messages="errors.password"
                />
                
                <v-checkbox
                  v-model="remember"
                  label="Remember me"
                />
                
                <v-btn
                  type="submit"
                  color="primary"
                  block
                  :loading="auth.loading"
                >
                  Login
                </v-btn>
              </v-form>
            </v-card-text>
            
            <v-card-actions class="justify-center">
              <v-btn text color="secondary" to="/forgot-password">
                Forgot Password?
              </v-btn>
            </v-card-actions>
          </v-card>
          
          <v-alert
            v-if="auth.error"
            type="error"
            class="mt-4"
          >
            {{ auth.error }}
          </v-alert>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script setup lang="ts">
  const email = ref('')
  const password = ref('')
  const remember = ref(false)
  const errors = ref({
    email: [],
    password: []
  })
  
  const auth = useAuthStore()
  
  async function handleLogin() {
    try {
      await auth.login({
        email: email.value,
        password: password.value
      })
    } catch (error) {
      // Handle validation errors
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors
      }
    }
  }
  </script>