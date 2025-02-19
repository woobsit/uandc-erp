import axiosInstance from './axiosInstance';
//js-cookies
import Cookies from 'js-cookie';
//api
import getAuthAdminData from './handleAuthAdminCookies'; // Import the getAuthAdminData function
import getAuthUserData from './handleAuthUserCookies'; // Import the getAuthUserData function

export const setupInterceptors = () => {
  axiosInstance.interceptors.request.use(
    (config) => {
      const authAdminData = getAuthAdminData();
      const authUserData = getAuthUserData();

      // List of routes that don't require authentication
      const publicRoutes = ['/get-all-courses', '/website-info'];

      // If the route is not public, attach the Authorization header
      if (!publicRoutes.includes(config.url)) {
        if (authUserData && authUserData.token) {
          config.headers['Authorization'] = `Bearer ${authUserData.token}`;
        } else if (authAdminData && authAdminData.token) {
          config.headers['Authorization'] = `Bearer ${authAdminData.token}`;
        }
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
      let redirectUrl = '/';
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
        alert(alertMessage);
      }

      return Promise.reject(error); // Propagate the error to further catch handling
    }
  );
};
