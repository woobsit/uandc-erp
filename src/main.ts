import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store'; // Import the store
import '@/assets/styles/main.scss'; // Import the global SCSS file

const app = createApp(App);

app.use(router); // Use the router
app.use(store); // Use the store

app.mount('#app');
