<template>
  <transition name="slide-out">

    <form
      v-if="!formSubmit"
      method="post"
      class="form-auth">

      <InformationMessageComponent
        v-show="isError"
        :is-success="isError"
      >
        {{ message }}
      </InformationMessageComponent>

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

    <MessageComponent v-else-if="formSubmit" @retry-event="handleRetry">
      You have reset the password
    </MessageComponent>

  </transition>
</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/atoms/form/BaseInputComponent.vue';
import { emailVerifier } from '@/helpers/emailVerifier';
import { getUserByEmail } from '@/services/user-service';
import MessageComponent from '@/components/demo/DemoMessageComponent.vue';
import InformationMessageComponent from '@/components/atoms/form/InformationMessageComponent.vue';

const email = ref('');
const isError = ref(false);
const message = ref('');
const formSubmit = ref(false);

async function handleSubmit() {
  if (email.value === '' || !emailVerifier(email.value)) {
    message.value = 'Please enter a valid email address';

    return;
  }

  if (!await getUserByEmail(email.value)) {
    message.value = 'Email invalid';

    return;
  }

  formSubmit.value = true;
}

function handleRetry() {
  formSubmit.value = false;
}
</script>
