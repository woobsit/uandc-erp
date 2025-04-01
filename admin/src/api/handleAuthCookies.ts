//js-cookies
import Cookies from 'js-cookie';

export function getAuthAdminData() {
  const authAdminDataCookie = Cookies.get('auth_admin_data');

  if (authAdminDataCookie) {
    const authData = JSON.parse(authAdminDataCookie);

    return {
      token: authData.token,
      admin_user: authData.admin_info,
      website_info: authData.settings,
    };
  }
  return null;
}

//This will be used for the user
export function getAuthUserData() {
  const authUserDataCookie = Cookies.get('auth_user_data');
  if (authUserDataCookie) {
    const authData = JSON.parse(authUserDataCookie);

    return {
      token: authData.token,
      user: authData.user_info,
      website_info: authData.settings,
    };
  }
  return null;
}
