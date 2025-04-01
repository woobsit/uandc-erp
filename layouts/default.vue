<!-- ~/layouts/default.vue -->
<template>
    <div class="root-layout">
      <NavBar /> 
      <main>
        <slot />  
      </main>
      <Footer /> 
    </div>
  </template>
  
  <script setup>
  // Auto-imports work for components
  </script>
  
  <style scoped>
  .root-layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  </style>