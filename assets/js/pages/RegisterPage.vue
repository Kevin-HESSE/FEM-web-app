<template>
  <form
    @submit.prevent="handleSubmit"
    class="form-auth"
  >

    <InformationMessageComponent
      v-show="message"
      :is-success="isSuccess"
    >
      {{ message }}
    </InformationMessageComponent>

    <h1>Sign Up</h1>

    <div class="form-auth__input" >
      <BaseInput
        v-model="email"
        label="Email address"
        type="email"
        required
      />
      <BaseInput
        v-model="username"
        label="Username"
        type="text"
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
      <button class="btn" :disabled="isLoading">Create an account</button>
      <p>Already have an account? <a class="cta" href="/login">Login</a></p>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import BaseInput from '@/components/atoms/form/BaseInputComponent.vue';
import InformationMessageComponent from '@/components/atoms/form/InformationMessageComponent.vue';
import { emailVerifier } from '@/helpers/emailVerifier';
import { createUser, getUserByEmail } from '@/services/user-service';

/** Variable needed to create the user */
const email = ref('');
const plainPassword = ref('');
const confirmation = ref('');
const username = ref('');

/** Variable needed to handle the form status */
const isSuccess = ref(false);
const isLoading = ref(false);
const message = ref('');

/**
 * Handle the register form by checking field.
 * @return {Promise<void>}
 */
async function handleSubmit() {
  if (plainPassword.value !== confirmation.value || plainPassword.value === '') {
    message.value = 'Please verify all passwords matches.';

    return;
  }

  if (!emailVerifier(email.value)) {
    message.value = 'Please enter a valid email address.';

    return;
  }

  try {
    const isUserExist = await getUserByEmail(email.value);

    if (isUserExist) {
      message.value = 'An account already exist.';

      return;
    }
  } catch (e) {
    message.value = 'An error has occurred. Please try again.';
    return;
  }

  message.value = 'User waiting for creation';
  isLoading.value = true;

  let createdUser;

  try {
    createdUser = await createUser({
      email: email.value,
      username: username.value,
      plainPassword: plainPassword.value,
    });
  } catch (e) {
    isLoading.value = false;
    message.value = 'An error has occured. Please try again later';
    return;
  }

  if (createdUser.status !== 201) {
    isLoading.value = false;
    message.value = 'An error has occured. Please try again later';
    return;
  }

  isLoading.value = false;
  isSuccess.value = true;
  message.value = 'User created. You will be redirected to the login page in few second.';

  setTimeout(() => {
    window.location.href = '/login';
  }, 2000);
}

</script>
