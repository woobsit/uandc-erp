<template>
  <a-layout-header style="background: #fff; padding: 0">
    <div class="topheader">
      <a-breadcrumb>
        <a-breadcrumb-item>Home</a-breadcrumb-item>
        <a-breadcrumb-item><a href="">Application Center</a></a-breadcrumb-item>
        <a-breadcrumb-item><a href="">Application List</a></a-breadcrumb-item>
        <a-breadcrumb-item>An Application</a-breadcrumb-item>
      </a-breadcrumb>
      <div class="demo-dropdown-wrap">
        <a-dropdown-button :trigger="['click']">
          <template v-if="loading">
            <a-spin />
          </template>
          <template v-else> Profile </template>
          <template #overlay>
            <a-menu @click="handleMenuClick">
              <a-menu-item key="1">
                <UserOutlined />
                Logout
              </a-menu-item>
            </a-menu>
          </template>
          <template #icon><UserOutlined /></template>
        </a-dropdown-button>
      </div>
    </div>
  </a-layout-header>
</template>

<script lang="ts">
import { ref } from 'vue';
import { UserOutlined } from '@ant-design/icons-vue';
import { useRouter } from 'vue-router';
import authService from '@/api/services';
import { notify } from '@/utils/notification';
import Cookies from 'js-cookie';

export default {
  components: { UserOutlined },
  setup() {
    const loading = ref(false); // Spinner state
    const router = useRouter();

    async function handleMenuClick() {
      loading.value = true; // Show spinner

      try {
        const response = await authService.adminLogout();

        if (response.status === 204) {
          Cookies.remove('auth_admin_data');
          router.push('/auth/login');
        } else if (response.status === 401) {
          notify({
            type: 'error',
            message: 'Unauthorized',
            description: response.message,
          });
        } else if (response.status === 500) {
          notify({
            type: 'error',
            message: 'System Error',
            description: response.message,
          });
        }
      } catch (error) {
        notify({
          type: 'error',
          message: 'Error',
          description: 'An unexpected error occurred. Please try again.',
        });
      } finally {
        loading.value = false; // Hide spinner after logout attempt
      }
    }

    return { handleMenuClick, loading };
  },
};
</script>

<style lang="scss" scoped>
.demo-dropdown-wrap :deep(.ant-dropdown-button) {
  margin-right: 8px;
  margin-bottom: 8px;
}
</style>
