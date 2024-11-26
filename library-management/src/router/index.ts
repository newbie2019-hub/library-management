import { createRouter, createWebHistory } from 'vue-router'
import { authRoutes, routes } from './routes'
import { ROUTE } from '@/@types/routes'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...authRoutes, ...routes]
})

router.beforeEach((to, from, next) => {
  const user = localStorage.getItem('user');

  if (to.meta.requiresAuth && !user) {
    next({ name: ROUTE.LOGIN })
  } else if (user && to.meta.guestPage) {
    next({ name: ROUTE.DASHBOARD })
  } else next()
})

export default router
