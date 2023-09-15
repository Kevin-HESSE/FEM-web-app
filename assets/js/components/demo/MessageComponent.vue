<template>
  <section class="demo">
    <h2 class="section-video__title">
      Congrats !
    </h2>
    <p><slot /></p>
    <p class="demo__description">
      However this application is a demo.
      So no data has been recorded.
      You can test the application by clicking the following button to log automatically with the test account.
    </p>
    <button class="btn" @click="handleConnect">Log in as test user</button>
    <button class="btn" @click="handleRetry">Test the form again</button>
  </section>
</template>

<script setup>

const emit = defineEmits(['retry-event']);
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
  emit('retry-event', true);
}
</script>
