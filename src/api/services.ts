import handleRequest from '@/api/handleRequest';

const authService = {
  adminLogin: (email: string, password: string, remember_token: boolean) =>
    handleRequest('/admin-login', 'post', { email, password, remember_token }),
  getAllOrders: (page = 1) => handleRequest(`/show-orders?page=${page}`),
};

export default authService;
