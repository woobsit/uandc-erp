<template>
  <div class="container">
    <!-- Overlay Spinner -->
    <div v-if="loading" class="overlay">
      <a-spin size="large" />
    </div>

    <form
      class="form components-input-demo-presuffix"
      @submit.prevent="handleSubmit"
    >
      <img class="form__logo" :src="logo" alt="logo" />
      <h2 class="form__heading--h2">Login</h2>
      <h4 class="form__heading--h5">Enter your login details</h4>

      <div class="form__input-div">
        <a-input
          placeholder="Email"
          v-model:value="email"
          @keyup="validateEmailOnKeyup"
          name="email"
          :disabled="loading"
        >
          <template #prefix>
            <user-outlined />
          </template>
        </a-input>
        <div class="form__typography--danger">
          <a-typography-text type="danger" v-if="errors.email">{{
            errors.email
          }}</a-typography-text>
        </div>
      </div>

      <div class="form__input-div">
        <a-input-password
          placeholder="Password"
          v-model:value="password"
          @blur="validatePasswordOnBlur"
          name="password"
          :disabled="loading"
        >
          <template #prefix>
            <lock-outlined />
          </template>
        </a-input-password>
        <div class="form__typography--danger">
          <a-typography-text type="danger" v-if="errors.password">{{
            errors.password
          }}</a-typography-text>
        </div>
      </div>

      <div class="form__remember-me-div">
        <div class="form__checkbox-div">
          <a-form-item>
            <a-checkbox v-model:checked="remember_me" :disabled="loading">
              Remember me
            </a-checkbox>
          </a-form-item>
        </div>
        <router-link to="" class="form__forget-password-text">
          Forget password?
        </router-link>
      </div>

      <button type="submit" :disabled="loading" class="form__button">
        Login
      </button>
    </form>
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue';
import { useRouter } from 'vue-router';
import { emailValidation } from '@/utils/validation';
import authService from '@/api/services';
import Cookies from 'js-cookie';
import { notify } from '@/utils/notification';
import logo from '@/assets/images/logo.png'; // Import the image

export default {
  name: 'LoginPage',
  components: { UserOutlined, LockOutlined },
  setup() {
    const email = ref(''); // Reactive state for email
    const password = ref(''); // Reactive state for password
    const remember_me = ref(false); // Reactive state for checkbox
    const errors = ref({ email: '', password: '' }); // Reactive state for email error message
    const loading = ref(false);

    // Vue Router instance for navigation
    const router = useRouter();

    function validateEmailOnKeyup() {
      if (!email.value) {
        errors.value.email = 'Email is required';
      } else if (!emailValidation(email.value)) {
        errors.value.email = 'Invalid email address';
      } else {
        errors.value.email = '';
      }
    }

    function validatePasswordOnBlur() {
      if (!password.value) {
        errors.value.password = 'Password is required';
      } else {
        errors.value.password = '';
      }
    }

    function handleSubmit() {
      validateEmailOnKeyup();
      validatePasswordOnBlur();

      if (!errors.value.email && !errors.value.password) {
        // The login function that makes the request
        const login = async () => {
          loading.value = true;
          try {
            // Call the authService's adminLogin method
            const response = await authService.adminLogin(
              email.value,
              password.value,
              remember_me.value
            );

            // Process response based on status code
            if (response.status === 200) {
              // Combine token, admin info, and any additional data
              const adminInfo = {
                token: response.token,
                admin_info: {
                  first_name: response.admin_info.firstname,
                  surname: response.admin_info.surname,
                  other_names: response.admin_info.other_names,
                  email: response.admin_info.email,
                  photo: response.admin_info.photo,
                  phone: response.admin_info.phone,
                },
                remember_me: response.admin_info.remember_me,
                settings: response.settings,
              };

              // Set the cookie based on the remember_me value
              // Here we assume that if remember_me is true, we keep the cookie for 30 days, otherwise 1 day

              //Searching if there is cookie before
              const cookieDataString = Cookies.get('auth_admin_data');
              let rememberMeCode: string | boolean | undefined;

              if (cookieDataString) {
                const parsedCookie = JSON.parse(cookieDataString);
                rememberMeCode = parsedCookie.admin_info.remember_me;
              } else {
                rememberMeCode = undefined;
              }

              // Stringify the combined data for the cookie
              const cookieData = JSON.stringify(adminInfo);

              if (
                !cookieDataString ||
                rememberMeCode !== adminInfo.remember_me
              ) {
                const expirationTime = remember_me.value ? 30 : 1;
                Cookies.set('auth_admin_data', cookieData, {
                  expires: expirationTime,
                  secure: true,
                  sameSite: 'lax',
                });
              }

              // Navigate to dashboad
              router.push('/home');
            } else if (response.status === 422) {
              notify({
                type: 'error',
                message: 'Input Validation',
                description: response.message,
              });
            } else if (response.status === 409) {
              notify({
                type: 'error',
                message: 'Login Conflict',
                description: response.message,
              });
            } else if (response.status === 401) {
              notify({
                type: 'error',
                message: 'User Login',
                description: response.message,
              });
            } else if (response.status === 403) {
              notify({
                type: 'error',
                message: 'User Login',
                description: response.message,
              });
            } else if (response.status === 500) {
              notify({
                type: 'error',
                message: 'System Error',
                description: response.message,
              });
            } else {
              notify({
                type: 'error',
                message: 'Error',
                description: 'An unexpected error occurred',
              });
            }
          } catch (error) {
            notify({
              type: 'error',
              message: 'Error',
              description: 'An unexpected error occurred. Please try again.',
            });
          } finally {
            loading.value = false;
          }
        };
        login();
      }
    }

    return {
      email,
      password,
      remember_me,
      errors,
      handleSubmit,
      logo,
      validateEmailOnKeyup,
      validatePasswordOnBlur,
      loading,
    };
  },
};
</script>

<style lang="scss" scoped></style>
