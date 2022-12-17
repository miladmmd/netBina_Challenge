import './bootstrap';
import {createApp} from "vue";
import App from '../js/App.vue';
import '../css/app.css';
import '../css/bootstrap.min.css';
import '../js/bootstrap.min';
import '../js/bootstrap.bundle.min';
import router from './router';

axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
createApp(App).use(router).mount("#app");
