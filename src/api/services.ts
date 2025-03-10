// src/api/services.ts
import handleRequest from '@/api/handleRequest';

export type APIParams = {
  page: number;
  results: number;
};

const authService = {
  adminLogin: (email: string, password: string, remember_token: boolean) =>
    handleRequest('/admin-login', 'post', { email, password, remember_token }),
  // Updated getAllOrders to accept an object of type APIParams
  getAllOrders: (params: APIParams) =>
    handleRequest('/show-orders', 'get', params),
};

export default authService;
