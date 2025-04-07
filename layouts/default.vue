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
  @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

  .root-layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  </style>