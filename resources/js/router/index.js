import { createRouter, createWebHistory } from 'vue-router';

import AuthLayout from '@/views/layout/Auth.vue';
import DashboardLayout from '@/views/layout/Dashboard.vue';
import AuthLoginPage from '@/views/pages/auth/Login.vue';
import AuthRegisterPage from '@/views/pages/auth/Register.vue';
import DashboardHome from '@/views/pages/dashboard/Home.vue';

const routes = [
  {
    path: '/', redirect: '/auth/login',
  },
  {
    path: '/auth', component: AuthLayout, redirect: '/auth/login',
    children: [
      {path: 'login', component: AuthLoginPage, meta: {middleware: 'guest'}},
      {path: 'register', component: AuthRegisterPage, meta: {middleware: 'guest'}},
    ]
  },
  {
    path: '/dashboard', component: DashboardLayout, redirect: '/dashboard/home',
    children: [
      {path: 'home', component: DashboardHome, meta: {middleware: 'auth'}}
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Router auth middleware
router.beforeEach((to, from, next) => {
  if (to.meta.middleware || to.meta.controller) {
    if (!localStorage.getItem('token') && to.meta.middleware.includes('auth')) {
      next('/auth/login');
    } else {
      next();
    }
  }
});

export default router;