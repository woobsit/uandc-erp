import axiosInstance from './axiosInstance';
//js-cookies
import Cookies from 'js-cookie';
import { getAuthAdminData, getAuthUserData } from '@/api/handleAuthCookies';
import { notify } from '@/utils/notification';

const setupInterceptors = () => {
  axiosInstance.interceptors.request.use(
    (config) => {
      const authAdminData: {
        token: any;
        admin_user: any;
        website_info: any;
      } | null = getAuthAdminData();

      const authUserData: {
        token: any;
        user: any;
        website_info: any;
      } | null = getAuthUserData();

      if (authUserData && authUserData.token) {
        config.headers['Authorization'] = `Bearer ${authUserData.token}`;
      } else if (authAdminData && authAdminData.token) {
        config.headers['Authorization'] = `Bearer ${authAdminData.token}`;
      }

      return config;
    },
    (error) => {
      return Promise.reject(error);
    }
  );

  axiosInstance.interceptors.response.use(
    (response) => response,
    (error) => {
      const authAdminData = getAuthAdminData();
      const authUserData = getAuthUserData();

      // Remove cookies if they exist
      if (authUserData) Cookies.remove('auth_user_data');
      if (authAdminData) Cookies.remove('auth_admin_data');

      // Determine the redirection URL and message
      const redirectUrl = '/auth/login';
      let alertMessage = '';

      if (error.response && error.response.status === 401) {
        // Unauthorized error
        alertMessage =
          'Session has expired. You have been logged out. Please try again later.';
      } else if (!error.response) {
        // Network/server issue
        alertMessage =
          'There seems to be a problem with the backend. Please try again later.';
      }

      if (alertMessage) {
        window.location.replace(redirectUrl);
        notify({ type: 'error', message: 'Error', description: alertMessage });
      }

      return Promise.reject(error); // Propagate the error to further catch handling
    }
  );
};

export default setupInterceptors;
