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
        <a-input placeholder="Email" v-model="email" @input="validateEmail">
          <template #prefix>
            <user-outlined />
          </template>
        </a-input>
        <a-typography-text type="danger" v-if="emailError">{{
          emailError
        }}</a-typography-text>
      </div>

      <div class="form__input-div">
        <a-input-password
          placeholder="Password"
          v-model="password"
          @input="validatePassword"
        >
          <template #prefix>
            <lock-outlined />
          </template>
        </a-input-password>
        <a-typography-text type="danger" v-if="passwordError">{{
          passwordError
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

      <button type="submit" class="form__button">Login</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue';
import { emailValidation } from '@/utils/validation.js';
import logo from '@/assets/images/logo.png'; // Import the image

export default defineComponent({
  components: { UserOutlined, LockOutlined },
  setup() {
    const email = ref(''); // Reactive state for email
    const password = ref(''); // Reactive state for password
    const checked = ref(false); // Reactive state for checkbox
    const emailError = ref(''); // Reactive state for email error message
    const passwordError = ref(''); // Reactive state for password error message
    const submitted = ref(false); // Flag indicating that the form was submitted

    // Email validation function
    const validateEmail = (): boolean => {
      if (!submitted.value) return true; // Skip validation if form hasn't been submitted
      if (!email.value) {
        emailError.value = 'Email is required';
        return false;
      } else if (!emailValidation(email.value)) {
        emailError.value = 'Invalid email address';
        return false;
      } else {
        emailError.value = '';
        return true;
      }
    };

    // Password validation function
    const validatePassword = (): boolean => {
      if (!submitted.value) return true; // Skip validation if form hasn't been submitted
      if (!password.value) {
        passwordError.value = 'Password is required';
        return false;
      } else {
        passwordError.value = '';
        return true;
      }
    };

    // Handle form submission
    const handleSubmit = () => {
      submitted.value = true; // Mark that submission was attempted
      const isEmailValid = validateEmail();
      const isPasswordValid = validatePassword();

      if (isEmailValid && isPasswordValid) {
        // Form is valid, proceed with login logic
        console.log('Form submitted successfully!');
        console.log('Email:', email.value);
        console.log('Password:', password.value);
        console.log('Remember me:', checked.value);

        // You can add your login API call or navigation logic here
      } else {
        // Form is invalid, do not proceed
        console.log('Form validation failed.');
      }
    };

    return {
      email,
      password,
      checked,
      emailError,
      passwordError,
      handleSubmit,
      logo,
      validateEmail, // Return validateEmail for use in the template
      validatePassword, // Return validatePassword for use in the template
    };
  },
});
</script>

<style lang="scss" scoped></style>
