import { createRouter, createWebHistory } from 'vue-router';

import AuthLayout from '@/views/layout/Auth.vue';
import DashboardLayout from '@/views/layout/Dashboard.vue';
import AuthLoginPage from '@/views/pages/auth/Login.vue';
import AuthRegisterPage from '@/views/pages/auth/Register.vue';
import DashboardHome from '@/views/pages/dashboard/Home.vue';
import UsersList from '@/views/pages/dashboard/users/List.vue';
import UsersEdit from '@/views/pages/dashboard/users/Edit.vue';
import UserRolesList from '@/views/pages/dashboard/user-roles/List.vue';
import UserRolesNew from '@/views/pages/dashboard/user-roles/New.vue';
import UserRolesEdit from '@/views/pages/dashboard/user-roles/Edit.vue';
import PermissionColumns from '@/views/pages/dashboard/PermissionColumns.vue';

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
      {path: 'home', component: DashboardHome, meta: {middleware: 'auth'}},
      {path: 'users', component: UsersList, meta: {middleware: 'auth', controller: 'App.Http.Controllers.Api.Dashboard.UserController'}},
      {path: 'users/:id/edit', component: UsersEdit, meta: {middleware: 'auth', controller: 'App.Http.Controllers.Api.Dashboard.UserController'}},
      {path: 'user-roles', component: UserRolesList, meta: {middleware: 'auth', controller: 'App.Http.Controllers.Api.Dashboard.UserRoleController'}},
      {path: 'user-roles/new', component: UserRolesNew, meta: {middleware: 'auth', controller: 'App.Http.Controllers.Api.Dashboard.UserRoleController'}},
      {path: 'user-roles/:id/edit', component: UserRolesEdit, meta: {middleware: 'auth', controller: 'App.Http.Controllers.Api.Dashboard.UserRoleController'}},
      {path: 'permission-columns', component: PermissionColumns, meta: {middleware: 'auth', controller: 'App.Http.Controllers.Api.Dashboard.PermissionColumnController'}},
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
    } else if(localStorage.getItem('token') && to.meta.middleware.includes('auth')) {
      axios.post('api/auth/check', {controller: to.meta.controller}).then(function(response) {
        if (!response.data.access) {
          next('/auth/login');
        } else {
          response.data.access ? next() : to.meta.controller ? next('/dashboard/home') : next('/auth/login');
        }
      });
    } else {
      next();
    }
  }
});

export default router;