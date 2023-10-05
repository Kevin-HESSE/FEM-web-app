<template>
  <form
    method="post"
    class="form-auth">

    <h1>Reset your password</h1>

    <div class="form-auth__input">
      <BaseInput
        v-model="email"
        name="email"
        label="Email address"
        type="email"
        required
      />

      <small>
        Enter your email address, and we will send you a
        link to reset your password.
      </small>
    </div>

    <div class="form-auth__cta">
      <button class="btn">Send password reset email</button>
      <p>Don't need to reset the password ? <a class="cta" href="/login">Login</a></p>
      <p>Don't have an account? <a class="cta" href="/register">Sign Up</a></p>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/atoms/form/BaseInputComponent.vue';

const email = ref('');
</script>
