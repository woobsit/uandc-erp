import handleRequest from '@/api/handleRequest';

const authService = {
  adminLogin: (email: string, password: string, remember_token: boolean) =>
    handleRequest('/admin-login', 'post', { email, password, remember_token }),
};

export default authService;
