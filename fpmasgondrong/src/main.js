import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import '@/assets/css/style.css'
import AOS from 'aos';
import 'aos/dist/aos.css';

// CSS
import 'admin-lte/dist/css/adminlte.min.css'
import '@fortawesome/fontawesome-free/css/all.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js' // JS untuk dropdown/modal Bootstrap


// JS

import 'bootstrap/dist/js/bootstrap.bundle.min.js'


// jQuery global (jika dibutuhkan plugin AdminLTE tertentu)
import $ from 'jquery'
window.$ = $
window.jQuery = $


AOS.init();
createApp(App).use(router).mount('#app')