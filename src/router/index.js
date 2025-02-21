import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
//import HomePage from '@/views/dashboard/Home.vue';
import LoginPage from '@/views/auth/LoginPage.vue';
import ForgetPassword from '@/views/auth/ForgetPassword.vue';
import ChangePassword from '@/views/auth/ChangePassword.vue';
import Dashboard from '@/views/dashboard/DashboardPage.vue';
import ViewOrders from '@/views/dashboard/ViewOrders.vue';
import CreateOrders from '@/views/dashboard/CreateOrders.vue';
import OrderHistory from '@/views/dashboard/OrderHistory.vue';

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    children: [
      {
        path: '',
        name: 'Home',
        component: Dashboard,
      },
      {
        path: 'view-orders',
        name: 'Orders',
        component: ViewOrders,
      },
      {
        path: 'create-orders',
        name: 'Create orders',
        component: CreateOrders,
      },
      {
        path:'orders-history',
        name: 'History',
        component: OrderHistory,
      }

    ],
  },
  {
    path: '/auth',
    component: AuthLayout, // Use AuthLayout for authentication pages
    children: [
      {
        path: 'login',
        name: 'Login',
        component: LoginPage,
      },
      {
        path: 'forget-password',
        name: 'Forget password',
        component: ForgetPassword,
      },
      {
        path: 'change-password',
        name: 'Change password',
        component: ChangePassword,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
