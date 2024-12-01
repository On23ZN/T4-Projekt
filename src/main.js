import './assets/main.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importiere den Router

// Erstelle die App und verwende den Router
createApp(App).use(router).mount('#app');
