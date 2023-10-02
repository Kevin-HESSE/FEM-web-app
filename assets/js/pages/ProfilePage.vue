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
        <div v-if="error" class="message error">
          {{ error }}
        </div>
        <div v-if="formSubmit" class="message success">
          <p>Password has been changed</p>
          <p v-if="demo">However it is a demo. No data has been updated.</p>
        </div>
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
import { isDemo } from '@/services/page-context';

const userInfo = ref({});
const plainPassword = ref('');
const confirmation = ref('');
const error = ref('');
const formSubmit = ref(false);
const demo = isDemo();
const accountStatus = computed(() => (userInfo.value.isVerified ? 'Verified' : 'Need to be verified'));

onBeforeMount(async () => {
  userInfo.value = await getUserInfo();
});

async function handleChangePassword() {
  if (!userInfo.value.isVerified) {
    error.value = 'Please verify your email first';
    return;
  }

  if (plainPassword.value !== confirmation.value) {
    error.value = "The two password doesn't correspond";
    return;
  }

  if (!demo) {
    const response = await updatedPassword(plainPassword.value);
    formSubmit.value = response.status === 200;
    error.value = response.status !== 200 ? 'A server error has occured, try later.' : '';
  } else {
    error.value = '';
    formSubmit.value = true;
  }

  plainPassword.value = '';
  confirmation.value = '';
}
</script>
