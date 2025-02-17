import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
//import HomePage from '@/views/dashboard/Home.vue';
import LoginPage from '@/views/auth/LoginPage.vue';
import ForgetPassword from '@/views/auth/ForgetPassword.vue';
import ChangePassword from '@/views/auth/ChangePassword.vue';

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    children: [
      {
        path: '',
        name: 'Home',
        // component: HomePage,
      },
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
