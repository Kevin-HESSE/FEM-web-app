<template>
  <form
    @submit.prevent="handleSubmit"
    class="form-auth"
  >
    <h1>Login</h1>

    <div v-if="error" class="message error">
      {{ error }}
    </div>

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
      <li>Email : <span class="cta" @click="handleEmailCompletion">toto@test.io</span></li>
      <li>Password : <span class="cta" @click="handlePasswordCompletion">archive</span></li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/atoms/form/BaseInputComponent.vue';
import { isDemo } from '@/services/page-context';

const email = ref('');
const password = ref('');
const error = ref('');
const demo = isDemo();

const handleEmailCompletion = () => {
  email.value = 'toto@test.io';
};

const handlePasswordCompletion = () => {
  password.value = 'archive';
};

const handleSubmit = async () => {
  try {
    // const response = await axios(options);
    const response = await fetch('/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        email: email.value,
        password: password.value,
      }),
    });

    if (!response.ok) {
      const data = await response.json();
      error.value = data.error;

      console.log(error.value);
      return;
    }

    window.location.href = '/';
  } catch (e) {
    console.log(e);
  }
};
</script>
