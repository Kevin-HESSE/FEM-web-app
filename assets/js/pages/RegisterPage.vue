<template>
  <transition name="slide-out">
    <form
      @submit.prevent="handleSubmit"
      class="form-auth"
      v-if="!formSubmit"
    >

      <ErrorMessage v-show="isError">
        {{ message }}
      </ErrorMessage>

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

    <MessageComponent v-else-if="formSubmit" @retry-event="handleRetry">
      You have created an account.
    </MessageComponent>

  </transition>

</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/atoms/form/BaseInputComponent.vue';
import ErrorMessage from '@/components/atoms/form/ErrorMessageComponent.vue';
import { emailVerifier } from '@/helpers/emailVerifier';
import MessageComponent from '@/components/demo/MessageComponent.vue';

const email = ref('');
const plainPassword = ref('');
const confirmation = ref('');
const isError = ref(false);
const message = ref('');
const formSubmit = ref(false);

function handleSubmit() {
  if (plainPassword.value !== confirmation.value) {
    isError.value = true;
    message.value = 'Please verify the password';

    return;
  }

  isError.value = !emailVerifier(email.value);

  if (isError.value) {
    message.value = 'Please enter a valid email address';

    return;
  }

  formSubmit.value = true;

  console.log('Success');
}

function handleRetry() {
  formSubmit.value = false;
}
</script>
