// src/api/services.ts
import handleRequest from '@/api/handleRequest';

export type APIParams = {
  page: number;
  results: number;
};

const authService = {
  adminLogin: (email: string, password: string, remember_token: boolean) =>
    handleRequest('/admin-login', 'post', { email, password, remember_token }),

  adminLogout: () => handleRequest('/admin-logout', 'post'),

  // Updated getAllOrders to accept an object of type APIParams
  getAllOrders: ({ page, results }: APIParams) =>
    handleRequest(`/show-orders?page=${page}&results=${results}`, 'get'),
};

export default authService;
