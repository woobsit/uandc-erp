<template>
  <div class="dashboard-container">
    <a-layout style="min-height: 100vh">
      <SideBar />
      <a-layout>
        <HeaderTemplate />
        <div class="content-container">
          <a-typography-title :level="3">Orders History</a-typography-title>
        </div>
        <FooterTemplate />
      </a-layout>
    </a-layout>
  </div>
</template>

<script lang="ts" setup>
import SideBar from '@/components/template/SidebarTemplate.vue';
</script>

<style scoped></style>
