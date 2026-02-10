import { createApp } from 'vue'
import App from "./App.vue";
import axios from "axios";
import '../css/artgui.css';

// Отключаем автоматическую обработку XSRF
axios.defaults.xsrfCookieName = null;
axios.defaults.xsrfHeaderName = null;

// Создаём экземпляр
const apiClient = axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
    }
});

// Interceptor для добавления токена
apiClient.interceptors.request.use(config => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (token) {
        config.headers['X-CSRF-TOKEN'] = token;
    }

    console.log('Sending request with CSRF token:', token); // Для отладки

    return config;
});

// Interceptor для ошибок
apiClient.interceptors.response.use(
    response => response,
    error => {
        console.error('Request failed:', error.response); // Для отладки

        if (error.response?.status === 419) {
            alert('CSRF token mismatch. Check console.');
        }

        return Promise.reject(error);
    }
);

const app = createApp({});
app.component('app', App);
app.config.globalProperties.$axios = apiClient;
app.provide('axios', apiClient);
app.mount('#app');