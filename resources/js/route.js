import {createWebHistory, createRouter } from 'vue-router';
import Home from './components/HomePage.vue';
import MainPage from './components/MainPage.vue';

const routes = [

  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/mainpage',
    name: 'mainpage',
    component: MainPage,
  },


];


const router = createRouter({
    history: createWebHistory(),
    routes
});


export default router;