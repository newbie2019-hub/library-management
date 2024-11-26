import { ROUTE } from '@/@types/routes';
import type { RouteRecordRaw } from 'vue-router';

export const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: ROUTE.HOME,
    component: () => import('../layouts/AuthenticatedLayout.vue'),
    meta: { requiresAuth: true },
    redirect: () => {
      return { name: ROUTE.DASHBOARD }
    },
    children: [
      {
        path: 'dashboard',
        name: ROUTE.DASHBOARD,
        component: () => import('../modules/dashboard/pages/UserDashboard.vue')
      },
      {
        path: 'authors',
        name: ROUTE.AUTHORS,
        component: () => import('../modules/author/pages/ManageAuthors.vue')
      },
      {
        path: 'books',
        name: ROUTE.MANAGE_BOOKS,
        component: () => import('../modules/books/pages/ManageBooks.vue')
      },
      {
        path: 'books',
        name: ROUTE.MEMBERS,
        component: () => import('../modules/members/pages/UserMembers.vue')
      },
      {
        path: 'categories',
        name: ROUTE.CATEGORIES,
        component: () => import('../modules/categories/pages/ManageCategories.vue')
      },
      {
        path: 'issued-books',
        name: ROUTE.ISSUED_BOOKS,
        component: () => import('../modules/issued-books/pages/IssuedBooks.vue')
      },
      {
        path: 'borrowed-books',
        name: ROUTE.BORROWED_BOOKS,
        component: () => import('../modules/borrowed-books/pages/BorrowedBooks.vue')
      },
      {
        path: 'returned-books',
        name: ROUTE.RETURNED_BOOKS,
        component: () => import('../modules/returned-books/pages/ReturnedBooks.vue')
      },
      {
        path: 'settings',
        name: ROUTE.SETTINGS,
        component: () => import('../modules/dashboard/pages/UserDashboard.vue')
      },
    ]
  },
]

export const authRoutes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('../layouts/GuestLayout.vue'),
    meta: { guestPage: true },
    children: [
      {
        path: 'login',
        name: ROUTE.LOGIN,
        component: () => import('../modules/auth/pages/AuthLogin.vue')
      },
      {
        path: 'register',
        name: ROUTE.REGISTER,
        component: () => import('../modules/auth/pages/AuthRegister.vue')
      },
    ]
  },
]