<template>
  <a-layout-sider v-model:collapsed="collapsed" collapsible>
    <a-menu v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
      <a-menu-item key="1">
        <dashboard-outlined />
        <span>Dashboard</span>
      </a-menu-item>
      <a-sub-menu key="sub1">
        <template #title>
          <span>
            <OrderedListOutlined />
            <span>Orders</span>
          </span>
        </template>
        <a-menu-item key="3">New order</a-menu-item>
        <a-menu-item key="4">View orders</a-menu-item>
      </a-sub-menu>
      <a-sub-menu key="sub2">
        <template #title>
          <span>
            <team-outlined />
            <span>Admins</span>
          </span>
        </template>
        <a-menu-item key="6">View admins</a-menu-item>
        <a-menu-item key="8">Create admin</a-menu-item>
      </a-sub-menu>
      <a-menu-item key="9">
        <SettingOutlined />
        <span>Settings</span>
      </a-menu-item>
    </a-menu>
  </a-layout-sider>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import {
  TeamOutlined,
  DashboardOutlined,
  OrderedListOutlined,
  SettingOutlined,
} from '@ant-design/icons-vue';

export default defineComponent({
  components: {
    TeamOutlined,
    DashboardOutlined,
    OrderedListOutlined,
    SettingOutlined,
  },
  setup() {
    const collapsed = ref<boolean>(false);
    const selectedKeys = ref<string[]>(['1']);

    // Return the variables so they can be used in the template
    return { collapsed, selectedKeys };
  },
});
</script>
