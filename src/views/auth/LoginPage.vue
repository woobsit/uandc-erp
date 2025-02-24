<template>
  <div class="container">
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
        >
          <template #prefix>
            <user-outlined />
          </template>
        </a-input>
        <a-typography-text
          class="form__typography--danger"
          type="danger"
          v-if="errors.email"
          >{{ errors.email }}</a-typography-text
        >
      </div>

      <div class="form__input-div">
        <a-input-password
          placeholder="Password"
          v-model:value="password"
          @blur="validatePasswordOnBlur"
        >
          <template #prefix>
            <lock-outlined />
          </template>
        </a-input-password>
        <a-typography-text type="danger" v-if="errors.password">{{
          errors.password
        }}</a-typography-text>
      </div>

      <div class="form__remember-me-div">
        <div class="form__checkbox-div">
          <a-form-item name="remember">
            <a-checkbox v-model="checked">Remember me</a-checkbox>
          </a-form-item>
        </div>
        <router-link to="" class="form__forget-password-text"
          >Forget password?</router-link
        >
      </div>

      <button type="submit" :disabled="loading" class="login-button">
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>
    </form>
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue';
import { useRouter } from 'vue-router';
import { emailValidation } from '@/utils/validation';
import authService from '@/api/services'; // Your authService with userLogin

import logo from '@/assets/images/logo.png'; // Import the image

export default {
  name: 'LoginPage',
  components: { UserOutlined, LockOutlined },
  setup() {
    const email = ref(''); // Reactive state for email
    const password = ref(''); // Reactive state for password
    const checked = ref(false); // Reactive state for checkbox
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
        // Call the authService's userLogin method
        const response = await authService.userLogin(
          email.value,
          password.value,
          rememberMe.value
        );
        
        // Process response based on status code
        if (response.status === 200) {
          // Combine token, user info, and any additional data
          const userInfo = {
            token: response.token,
            user_info: {
              firstname: response.user_info.firstname,
              surname: response.user_info.surname,
              other_names: response.user_info.other_names,
              email: response.user_info.email,
              photo: response.user_info.photo,
              admission_status: response.user_info.admission_status,
              // ... include other properties as needed
            },
            website_info: response.website_info,
          };
          
          // Stringify the combined data for the cookie
          const cookieData = JSON.stringify(userInfo);
          
          // Set the cookie based on the rememberMe value
          // Here we assume that if rememberMe is true, we keep the cookie for 30 days, otherwise 1 day
          if (!Cookies.get("auth_admin_data")) {
            const expirationTime = rememberMe.value ? 30 : 1;
            Cookies.set("auth_user_data", cookieData, {
              expires: expirationTime,
              secure: true,
              sameSite: "lax",
            });
            
            // Navigate based on the user's admission status
            if (response.user_info.admission_status === "Admitted") {
              router.push('/home');
            } else {
              router.push('/admission');
            }
          } else if (!Cookies.get("auth_user_data")) {
            router.push('/');
          }
        } else if (response.status === 422) {
          notify("error", "Input Validation", response.message);
        } else if (response.status === 409) {
          notify("error", "Login Conflict", response.message);
        } else if (response.status === 401) {
          notify("error", "User Login", response.message);
        } else if (response.status === 500) {
          notify("error", "System Error", response.message);
        } else {
          notify("error", "Error", "An unexpected error occurred");
        }
      } catch (error) {
        notify("error", "Error", "An unexpected error occurred. Please try again.");
      } finally {
        loading.value = false;
      }
    };
      }
    }

    return {
      email,
      password,
      checked,
      errors,
      handleSubmit,
      logo,
      validateEmailOnKeyup,
      validatePasswordOnBlur,
    };
  },
};
</script>

<style lang="scss" scoped></style>
