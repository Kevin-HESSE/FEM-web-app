import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './pages/BookmarkPage.vue';

const pinia = createPinia();

createApp(App)
  .use(pinia)
  .mount('#app');
