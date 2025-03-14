<template>
  <a-layout-sider
    breakpoint="lg"
    collapsed-width="0"
    @collapse="onCollapse"
    @breakpoint="onBreakpoint"
  >
    <a-menu v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
      <a-menu-item key="1">
        <dashboard-outlined />
        <span><router-link to="/">Dashboard</router-link></span>
      </a-menu-item>
      <a-sub-menu key="sub1">
        <template #title>
          <span>
            <OrderedListOutlined />
            <span>Orders</span>
          </span>
        </template>
        <a-menu-item key="3">
          <router-link to="/create-orders">New order</router-link></a-menu-item
        >
        <a-menu-item key="4">
          <router-link to="/view-orders">View orders</router-link></a-menu-item
        >
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
    const selectedKeys = ref<string[]>(['4']);
    const onCollapse = (collapsed: boolean, type: string) => {
      console.log(collapsed, type);
    };

    const onBreakpoint = (broken: boolean) => {
      console.log(broken);
    };

    // Return the variables so they can be used in the template
    return { onCollapse, onBreakpoint, selectedKeys };
  },
});
</script>
