import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/login' },
    {
      path: '/logout',
      redirect: '/login',
    },
    {
      path: '/',
      component: () => import('../layouts/default.vue'),
      children: [
        {
          path: 'dashboard/:role',
          name: 'dashboard',
          component: () => import('../pages/dashboard.vue'),
        },
        {
          path: 'module-form/:moduleId',
          component: () => import('../pages/modules/form.vue'),
        },
        {
          path: 'module-form',
          component: () => import('../pages/modules/form.vue'),
        },
        {
          path: 'modules-list',
          component: () => import('../pages/modules/list.vue'),
        },
        {
          path: 'modules-view/:stage',
          component: () => import('../pages/modules/view.vue'),
        },
        {
          path: 'employee-form/:employeeId',
          component: () => import('../pages/employees/form.vue'),
        },
        {
          path: 'employee-form',
          component: () => import('../pages/employees/form.vue'),
        },
        {
          path: 'employees-list',
          component: () => import('../pages/employees/list.vue'),
        },
        {
          path: 'icons',
          component: () => import('../pages/icons.vue'),
        },
        {
          path: 'cards',
          component: () => import('../pages/cards.vue'),
        },
        {
          path: 'tables',
          component: () => import('../pages/tables.vue'),
        },
        {
          path: 'feedback-form',
          component: () => import('../pages/feedback/form.vue'),
        },
        {
          path: 'feedback-list',
          component: () => import('../pages/feedback/list.vue'),
        },
       
      ],
    },
    {
      path: '/',
      component: () => import('../layouts/blank.vue'),
      children: [
        {
          path: 'login',
          component: () => import('../pages/login.vue'),
        },
        {
          path: 'register',
          component: () => import('../pages/register.vue'),
        },
        {
          path: '/:pathMatch(.*)*',
          component: () => import('../pages/[...all].vue'),
        },
      ],
    },
  ],
})

export default router
