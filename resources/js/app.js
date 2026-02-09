import { createApp } from 'vue'
import App from "./App.vue";
import axios from "axios";
import '../css/artgui.css';

const app = createApp({});

// Регистрация компонента
app.component('app', App);

// Глобальный axios (Vue 3 способ)
app.config.globalProperties.$axios = axios;

// Provide для Composition API
app.provide('axios', axios);

app.mount('#app');