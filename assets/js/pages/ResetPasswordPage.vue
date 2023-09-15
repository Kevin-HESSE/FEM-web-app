<template>
  <transition name="slide-out">

    <form
      v-if="!formSubmit"
      @submit.prevent="handleSubmit"
      class="form-auth">

      <ErrorMessage v-show="isError">
        {{ message }}
      </ErrorMessage>

      <h1>Reset your password</h1>

      <div class="form-auth__input">
        <BaseInput
          v-model="email"
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

    <MessageComponent v-else-if="formSubmit" @retry-event="handleRetry">
      You have reset the password
    </MessageComponent>

  </transition>
</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/form/BaseInputComponent.vue';
import { emailVerifier } from '@/helpers/emailVerifier';
import { getUserByEmail } from '@/services/user-service';
import ErrorMessage from '@/components/form/ErrorMessageComponent.vue';
import MessageComponent from '@/components/demo/MessageComponent.vue';

const email = ref('');
const isError = ref(false);
const message = ref('');
const formSubmit = ref(false);

async function handleSubmit() {
  if (email.value === '' || !emailVerifier(email.value)) {
    isError.value = true;
    message.value = 'Please enter a valid email address';

    return;
  }

  isError.value = !await getUserByEmail(email.value);

  if (isError.value) {
    message.value = 'Email invalid';

    return;
  }

  formSubmit.value = true;
}

function handleRetry() {
  formSubmit.value = false;
}
</script>
