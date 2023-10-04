<template>
  <MainLayout>
    <h1>Profile</h1>
    <section class="profile-section">
      <h2>Informations</h2>
      <div class="profile-information">
        <img class="profile-information__avatar" src="/build/images/image-avatar.png" alt="Profile picture">
        <ProfileInformationComponent
          label="Username"
          :user-info="userInfo.username"
        />
        <ProfileInformationComponent
          label="Email"
          :user-info="userInfo.email"
        />
        <ProfileInformationComponent
          label="Account status"
          :user-info="accountStatus"
        />
      </div>
    </section>
    <section class="profile-section">
      <h2>Change password</h2>
      <form class="form" @submit.prevent="handleChangePassword">
        <InformationMessageComponent
          v-if="message"
          :is-error="isError"
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
    </section>
  </MainLayout>
</template>

<script setup>
import { computed, onBeforeMount, ref } from 'vue';
import MainLayout from '@/layout/MainLayout.vue';
import { getUserInfo, updatedPassword } from '@/services/user-service';
import ProfileInformationComponent from '@/components/atoms/ProfileInformationComponent.vue';
import BaseInputComponent from '@/components/atoms/form/BaseInputComponent.vue';
import InformationMessageComponent from '@/components/atoms/form/InformationMessageComponent.vue';

const userInfo = ref({});

/** Variable neeeded for the reset password form*/
const plainPassword = ref('');
const confirmation = ref('');

/** Variable needed to handle the reset password form */
const isError = ref(false);
const message = ref('');

const accountStatus = computed(() => (userInfo.value.isVerified ? 'Verified' : 'Need to be verified'));

onBeforeMount(async () => {
  userInfo.value = await getUserInfo();
});

async function handleChangePassword() {
  if (!userInfo.value.isVerified) {
    isError.value = true;
    message.value = 'Please verify your email first';
    return;
  }

  if (plainPassword.value !== confirmation.value) {
    isError.value = true;
    message.value = "The two password doesn't correspond";
    return;
  }

  if (userInfo.value.email === 'toto@test.io' || userInfo.value.email === 'tata@test.io') {
    isError.value = true;
    message.value = "This password of this address email can't be changed";
    return;
  }

  const response = await updatedPassword(plainPassword.value);
  isError.value = response.status !== 200;
  message.value = response.status !== 200 ? 'A server error has occured, try later.' : 'Password has been updated';
  plainPassword.value = '';
  confirmation.value = '';
}
</script>
