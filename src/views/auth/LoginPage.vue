<template>
  <div class="container">
    <form class="form components-input-demo-presuffix">
      <img class="form__logo" :src="logo" alt="" />
      <h2 class="form__heading--h2">Login</h2>
      <h5 class="form__heading--h5">Enter your login details</h5>

      <div class="form__input-div">
        <a-input
          placeholder="Email"
          @input="debounceEmailValidation"
          v-model:value="email"
        >
          <template #prefix>
            <user-outlined />
          </template>
        </a-input>
        <span v-if="emailError" class="error-message">{{ emailError }}</span>
      </div>
      <div class="form__input-div">
        <a-input-password
          placeholder="Password"
          @input="debouncePasswordValidation"
          v-model:value="email"
        >
          <template #prefix>
            <lock-outlined />
          </template>
        </a-input-password>
        <span v-if="passwordError" class="error-message">{{
          passwordError
        }}</span>
      </div>

      <div class="form__remember-me-div">
        <div class="form__checkbox-div">
          <template>
            <a-checkbox v-model:checked="checked">Checkbox</a-checkbox>
          </template>
          <!-- <input
            type="checkbox"
            id="remember-me"
            class="form__checkbox"
          /><label for="remember-me" class="form__checkbox-label"
            >Remember me</label
          > -->
        </div>
        <router-link to="" class="form__forget-password-text"
          >Forget password?</router-link
        >
      </div>
      <button class="form__button">Login</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue';
import logo from '@/assets/images/logo.png'; // Import the image

export default defineComponent({
  components: { UserOutlined, LockOutlined },
  setup() {
    const email = ref(''); // Reactive state for email
    const password = ref(''); // Reactive state for password
    const checked = ref(false); // Reactive state for checkbox
    const emailError = ref(''); // Reactive state for email error message
    const passwordError = ref(''); // Reactive state for password error message

    // Email validation function
    const validateEmail = () => {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email regex
      if (!email.value) {
        emailError.value = 'Email is required';
      } else if (!emailRegex.test(email.value)) {
        emailError.value = 'Invalid email address';
      } else {
        emailError.value = '';
      }
    };

    // Password validation function
    const validatePassword = () => {
      if (!password.value) {
        passwordError.value = 'Password is required';
      } else {
        passwordError.value = '';
      }
    };

    // Debounce function to delay validation
    type AnyFunction = (...args: any[]) => any;
    const debounce = (fn: AnyFunction, delay: number) => {
      let timeoutId: number;
      return (...args: any[]) => {
        if (timeoutId) clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
      };
    };

    // Debounced validation functions
    const debounceEmailValidation = debounce(validateEmail, 500);
    const debouncePasswordValidation = debounce(validatePassword, 500);

    return {
      email,
      password,
      checked,
      emailError,
      passwordError,
      debounceEmailValidation,
      debouncePasswordValidation,
      logo,
    };
  },
});
</script>

<style lang="scss" scoped></style>
