<template>
    <v-app-bar
      app
      dark
      elevate-on-scroll
      class="bg-transparent pl-3 fixed"
      
    >
      <!-- Logo/Title on the left -->
       <nuxt-link to="/" class="d-flex align-center text-decoration-none">
        <img 
        src="/images/logo.png" 
        :alt="appTitle"
        class="logo-image"
      />
    </nuxt-link>
  
      <!-- Desktop Navigation -->
      <v-toolbar-items class="ml-5 hidden-sm-and-down">
        <v-btn
          v-for="(item, index) in navItems"
          :key="index"
          :to="item.to"
          text
          exact
          active-class="active-nav-item"
        >
          {{ item.title }}
        </v-btn>
      </v-toolbar-items>
  
      <!-- Spacer to push items to the right -->
      <v-spacer></v-spacer>
  
      <!-- Right side items -->
      <v-btn icon class="hidden-sm-and-down" @click="toggleSearch">
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
  
      <v-btn icon class="hidden-sm-and-down ml-2">
        <v-badge dot color="error">
          <v-icon>mdi-bell-outline</v-icon>
        </v-badge>
      </v-btn>
  
      <!-- User menu (if authenticated) -->
      <v-menu
        v-if="user"
        bottom
        left
        offset-y
        transition="slide-y-transition"
      >
        <template #activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
          >
            <v-avatar size="32">
              <v-img :src="user.avatar || 'https://cdn.vuetifyjs.com/images/john.jpg'" />
            </v-avatar>
          </v-btn>
        </template>
  
        <v-list>
          <v-list-item
            v-for="(item, index) in userMenuItems"
            :key="index"
            :to="item.to"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
  
      <!-- Mobile menu button -->
      <v-app-bar-nav-icon
        class="hidden-md-and-up"
        @click="drawer = !drawer"
      />
    </v-app-bar>
  
    <!-- Mobile Navigation Drawer -->
    <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
      right
    >
      <v-list>
        <v-list-item
          v-for="(item, index) in navItems"
          :key="index"
          :to="item.to"
          exact
        >
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
  
        <!-- Show auth buttons on mobile if not logged in -->
        <template v-if="!user">
          <v-divider class="my-2" />
          <v-list-item to="/login">
            <v-list-item-title>Login</v-list-item-title>
          </v-list-item>
          <v-list-item to="/register">
            <v-list-item-title>Register</v-list-item-title>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>
  
    <!-- Search dialog -->
    <v-dialog v-model="searchDialog" max-width="600">
      <v-card>
        <v-card-title>
          <v-text-field
            v-model="searchQuery"
            autofocus
            placeholder="Search..."
            prepend-inner-icon="mdi-magnify"
            hide-details
            clearable
            @keyup.enter="performSearch"
          />
        </v-card-title>
      </v-card>
    </v-dialog>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue'
  import { useAuthStore } from '~/stores/auth' // Assuming you're using Pinia
  //import logo from '~/assets/images/logo.png'

  const appTitle = ref('U&C wheels')
  const drawer = ref(false)
  const searchDialog = ref(false)
  const searchQuery = ref('')
  
  // Authentication state (using Pinia)
  const authStore = useAuthStore()
  const user = computed(() => authStore.user)
  
  const navItems = ref([
    { title: 'Home', to: '/' },
    { title: 'About', to: '/about' },
    { title: 'Services', to: '/services' },
    { title: 'Contact', to: '/contact' },
  ])
  
  const userMenuItems = ref([
    { title: 'Profile', to: '/profile', icon: 'mdi-account' },
    { title: 'Settings', to: '/settings', icon: 'mdi-cog' },
    { title: 'Logout', to: '/logout', icon: 'mdi-logout' },
  ])
  
  function toggleSearch() {
    searchDialog.value = !searchDialog.value
    if (searchDialog.value) {
      searchQuery.value = ''
    }
  }
  
  function performSearch() {
    if (searchQuery.value) {
      // Handle search logic
      console.log('Searching for:', searchQuery.value)
      // You might want to navigate to search results page
      // navigateTo(`/search?q=${searchQuery.value}`)
      searchDialog.value = false
    }
  }
  </script>
  
  <style scoped>
  .logo-image {
  height: 40px; /* Adjust as needed */
  width: auto; /* Maintain aspect ratio */
  max-width: 150px; /* Prevent too wide */
  object-fit: contain; /* Similar to v-img's contain */
}

/* Ensure header stays transparent */
.v-app-bar {
  background: transparent !important;
  box-shadow: none !important;
}

.v-app-bar--is-scrolled {
  background: rgba(0, 0, 0, 0.7) !important;
  backdrop-filter: blur(5px);
}
  </style>