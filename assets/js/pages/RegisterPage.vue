<template>
  <transition name="slide-out">
    <form
      @submit.prevent="handleSubmit"
      class="form-auth"
      v-if="!formSubmit"
    >

      <div v-show="error" class="message error" role="alert">
        <p>{{ errorMessage }}</p>
      </div>

      <h1>Sign Up</h1>

      <div class="form-auth__input" >
        <BaseInput
          v-model="email"
          label="Email address"
          type="email"
          required
        />
        <BaseInput
          v-model="plainPassword"
          label="Password"
          type="password"
          required
        />
        <BaseInput
          v-model="confirmation"
          label="Confirm password"
          type="password"
          required
        />
      </div>

      <div class="form-auth__cta">
        <button class="btn">Create an account</button>
        <p>Already have an account? <a class="cta" href="/login">Login</a></p>
      </div>
    </form>

    <section v-else-if="formSubmit" class="demo">
      <h2 class="section-video__title">
        Congrats !
      </h2>
      <p>You have created an account.</p>
      <p class="demo__description">
        However this application is a demo.
        So no data has been recorded.
        You can test the application by clicking the following button to log automatically with the test account.
      </p>
      <button class="btn" @click="handleConnect">Log in as test user</button>
      <button class="btn" @click="handleRetry">Test the register form again</button>
    </section>
  </transition>

</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/form/BaseInput.vue';

const email = ref('');
const plainPassword = ref('');
const confirmation = ref('');
const error = ref(false);
const errorMessage = ref('');
const formSubmit = ref(false);

function handleSubmit() {
  if (plainPassword.value !== confirmation.value) {
    error.value = true;
    errorMessage.value = 'Please verify the password';

    return;
  }

  const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  if (!regex.test(String(email.value).toLowerCase())) {
    error.value = true;
    errorMessage.value = 'Please enter a valid email address';

    return;
  }

  error.value = false;
  formSubmit.value = true;

  console.log('Hello');
}

async function handleConnect() {
  try {
    await fetch('/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        email: 'tata@test.io',
        password: 'archive',
      }),
    });

    window.location.href = '/';
  } catch (e) {
    console.log(e);
  }
}

function handleRetry() {
  formSubmit.value = false;
  email.value = '';
  plainPassword.value = '';
  confirmation.value = '';
}
</script>
