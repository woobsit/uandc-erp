// src/api/services.ts
import handleRequest from '@/api/handleRequest';
import type { APIParams, CreateOrderParams } from '@/types';

const authService = {
  //Admin login services
  adminLogin: (email: string, password: string, remember_token: boolean) =>
    handleRequest('/admin-login', 'post', { email, password, remember_token }),
  //Logout services for the admin
  adminLogout: () => handleRequest('/admin-logout', 'post'),

  // get all orders by admin
  getAllOrders: ({ page, results }: APIParams) =>
    handleRequest(`/show-orders?page=${page}&results=${results}`, 'get'),

  // Create a new order
  createOrder: (orderData: CreateOrderParams) =>
    handleRequest('/create-orders', 'post', orderData),
};

export default authService;
