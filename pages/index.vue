<!-- ~/pages/index.vue -->
<template>
  <div>
    <AppHeader/>
    <HeroSlider/>
    <NuxtLink to="/about" class="text-blue-500">
</NuxtLink>
  </div>
</template>
<script setup>
import AppHeader from '~/components/templates/AppHeader.vue';
import HeroSlider from '~/components/templates/HeroSlider.vue';

</script>