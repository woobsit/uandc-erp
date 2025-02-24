import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store'; // Import the store
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/reset.css';
import '@/assets/styles/main.scss'; // Import the global SCSS file
import setupInterceptors from '@/api/interceptors';

setupInterceptors();
const app = createApp(App);

app.use(router); // Use the router
app.use(store); // Use the store
app.use(Antd);

app.mount('#app');
