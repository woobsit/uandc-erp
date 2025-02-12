import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import LoginPage from '@/views/LoginPage.vue';
import ForgetPassword from '@/views/ForgetPassword.vue';
import ChangePassword from '@/views/ChangePassword.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: LoginPage,
  },
  {
    path: '/forget-password',
    name: 'Forget password',
    component: ForgetPassword,
  },
  {
    path: '/change-password',
    name: 'Change password',
    component: ChangePassword,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
