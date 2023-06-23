import '@/plugins/axios';

import { createApp } from 'vue';
import App from './views/App.vue';
import router from './router';
import store from './store';
import Notifications from '@kyvg/vue3-notification';
import './style.css';

const app = createApp(App);

app.use(router);
app.use(store);
app.use(Notifications);

app.mount('#app');