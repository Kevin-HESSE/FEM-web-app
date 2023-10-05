<template>
  <form
    :class="{
      form: !isAuth,
      'form-auth': isAuth
    }"
    @submit.prevent="handleChangePassword"
  >

    <slot/>

    <InformationMessageComponent
      v-if="message"
      :is-success="isSuccess"
    >
      {{ message }}
    </InformationMessageComponent>
    <BaseInputComponent
      v-model="plainPassword"
      label="New password"
      type="password"
      required
    />
    <BaseInputComponent
      v-model="confirmation"
      label="Confirm password"
      type="password"
      required
    />
    <button class="btn" type="submit">
      Change the password
    </button>
  </form>
</template>
<script setup>
import { ref } from 'vue';
import InformationMessageComponent from '@/components/atoms/form/InformationMessageComponent.vue';
import BaseInputComponent from '@/components/atoms/form/BaseInputComponent.vue';
import { updatedPassword } from '@/services/user-service';

const props = defineProps({
  userInfo: {
    type: Object,
  },
  isAuth: {
    type: Boolean,
    default: false,
  },
});

/** Variable neeeded for the reset password form*/
const plainPassword = ref('');
const confirmation = ref('');

/** Variable needed to handle the reset password form */
const isSuccess = ref(false);
const message = ref('');

function checkUserInfo() {
  if (!props.userInfo.isVerified) {
    message.value = 'Please verify your email first';
    return false;
  }

  /** Section to avoid the change of password from test user inside the profile section */
  if (props.userInfo.email === 'toto@test.io' || props.userInfo.email === 'tata@test.io') {
    isSuccess.value = true;
    message.value = "The password of this email address can't be changed";
    return false;
  }

  return true;
}

/**
 * Handle the password change form.
 * @return {Promise<void>}
 */
async function handleChangePassword() {
  /** Check if we pass userInfo which is not used in the ResetPasswordFormPage */
  if (props.userInfo !== undefined) {
    const check = checkUserInfo();

    if (!check) {
      plainPassword.value = '';
      confirmation.value = '';
      return;
    }
  }

  if (plainPassword.value !== confirmation.value) {
    message.value = "The two password doesn't correspond";
    return;
  }

  const response = await updatedPassword(plainPassword.value);

  if (response.status !== 200) {
    message.value = 'A server error has occured, try later.';
    return;
  }

  plainPassword.value = '';
  confirmation.value = '';
  isSuccess.value = true;

  if (props.isAuth) {
    message.value = 'Password has been updated. You will be redirect to the login page in few second.';
    setTimeout(() => {
      window.location.href = '/login';
    }, 2000);
  } else {
    message.value = 'Password has been updated';
  }
}
</script>
