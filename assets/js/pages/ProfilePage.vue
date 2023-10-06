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
      <ResetPasswordForm
        :user-info="userInfo"
      />
    </section>
  </MainLayout>
</template>

<script setup>
import { computed, onBeforeMount, ref } from 'vue';
import MainLayout from '@/layout/MainLayout.vue';
import { getUserInfo } from '@/services/user-service';
import ProfileInformationComponent from '@/components/atoms/ProfileInformationComponent.vue';
import ResetPasswordForm from '@/components/molecules/ResetPasswordForm.vue';

const userInfo = ref({});

const accountStatus = computed(() => (userInfo.value.isVerified ? 'Verified' : 'Need to be verified'));

onBeforeMount(async () => {
  try {
    userInfo.value = await getUserInfo();
  } catch (e) {
    console.log(e);
  }
});

</script>
