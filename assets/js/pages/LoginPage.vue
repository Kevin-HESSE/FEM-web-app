<template>
  <form
    @submit.prevent="handleSubmit"
    class="form-auth"
  >
    <h1>Login</h1>

    <InformationMessageComponent v-if="message">
      {{ message }}
    </InformationMessageComponent>

    <div class="form-auth__input">
      <BaseInput
        v-model="email"
        label="Email address"
        type="email"
        required
      />
      <BaseInput
        v-model="password"
        label="Password"
        type="password"
        required
      />
    </div>
    <div class="form-auth__cta">
      <p><a class="cta" href="/reset-password">Lost your password ?</a></p>
      <button class="btn">Login to your account</button>
      <p>Don't have an account? <a class="cta" href="/register">Sign Up</a></p>
    </div>
  </form>

  <div v-if="demo" class="demo">
    <p>You can autocomplete the form with the following information : </p>
    <ul>
      <li>Email : <span class="cta" @click="handleEmailCompletion">admin@entertainment.io</span></li>
      <li>Password : <span class="cta" @click="handlePasswordCompletion">archive</span></li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/atoms/form/BaseInputComponent.vue';
import { isDemo } from '@/services/page-context';
import InformationMessageComponent from '@/components/atoms/form/InformationMessageComponent.vue';
import { loginUser } from '@/services/user-service';

const email = ref('');
const password = ref('');
const message = ref('');
const demo = isDemo();

const handleEmailCompletion = () => {
  email.value = 'admin@entertainment.io';
};

const handlePasswordCompletion = () => {
  password.value = 'archive';
};

const handleSubmit = async () => {
  let response;

  try {
    response = await loginUser({
      email: email.value,
      password: password.value,
    });
  } catch (e) {
    message.value = 'An error has occurred. Please try again.';
    return;
  }

  if (!response.ok) {
    const error = await response.json();
    message.value = error.error;
    return;
  }

  window.location.href = '/';
};
</script>
