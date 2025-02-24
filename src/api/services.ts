import handleRequest from '@/api/handleRequest';

const authService = {
  userLogin: (email: string, password: string, remember_token: string) =>
    handleRequest('/admin-login', 'post', { email, password, remember_token }),
};

export default authService;
