<!-- ~/layouts/default.vue -->
<template>
   
   <v-app>
    <div class="root-layout">
      <Head>
      <Title>UandC wheels</Title>
      <Meta name="description" content="Professional logistics and shipping solutions" />
      <Meta name="keywords" content="logistics, shipping, freight" />
    </Head>
      <N
      avBar /> 
      <main>
        <slot />  
      </main>
      <Footer /> 
    </div>
  </v-app>
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