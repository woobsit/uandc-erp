import { createRouter, createWebHistory } from 'vue-router';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
//import HomePage from '@/views/dashboard/Home.vue';
import LoginPage from '@/views/auth/LoginPage.vue';
import ForgetPassword from '@/views/auth/ForgetPassword.vue';
import ChangePassword from '@/views/auth/ChangePassword.vue';
import Dashboard from '@/views/dashboard/DashboardPage.vue';
import ViewOrders from '@/views/dashboard/ViewOrders.vue';
import CreateOrders from '@/views/dashboard/CreateOrders.vue';
//import OrderHistory from '@/views/dashboard/OrderHistory.vue';
import Cookies from 'js-cookie';

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    children: [
      {
        path: 'home',
        name: 'Home',
        component: Dashboard,
        meta: { requiresAuth: true },
      },
      {
        path: 'view-orders',
        name: 'Orders',
        component: ViewOrders,
        meta: { requiresAuth: true },
      },
      {
        path: 'create-orders',
        name: 'Create orders',
        component: CreateOrders,
        meta: { requiresAuth: true },
      },
      // {
      //   path: 'orders-history',
      //   name: 'History',
      //   component: OrderHistory,
      // },
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
        meta: { requiresGuest: true },
      },
      {
        path: 'forget-password',
        name: 'Forget password',
        component: ForgetPassword,
        meta: { requiresGuest: true },
      },
      {
        path: 'change-password',
        name: 'Change password',
        component: ChangePassword,
        meta: { requiresGuest: true },
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Global Navigation Guard
router.beforeEach((to, from, next) => {
  // Check if user is authenticated by reading the cookie (or from a store)
  const isAuthenticated = !!Cookies.get('auth_admin_data');

  if (to.meta.requiresAuth && !isAuthenticated) {
    // If the route requires authentication and the user is not authenticated,
    // redirect to the login page.
    return next({ name: 'login' });
  } else if (to.meta.requiresGuest && isAuthenticated) {
    // If the route is for guests only (like login) and the user is authenticated,
    // redirect them to a protected route (e.g., home/dashboard).
    return next({ name: 'home' });
  } else {
    // Otherwise, proceed as normal
    return next();
  }
});

export default router;
