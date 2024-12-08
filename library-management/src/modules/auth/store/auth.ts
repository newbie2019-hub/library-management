import { ref } from 'vue'
import { defineStore } from 'pinia'
import { api } from '@/lib/api'
import type { UserLogin } from '../schema/auth'
import { RESPONSE } from '@/@types/status'
import { toast } from 'vue-sonner'
import router from '@/router'
import { ROUTE } from '@/@types/routes'

export const useAuthStore = defineStore('authentication', () => {
  const storedUser = localStorage.getItem('user')

  const user = ref((storedUser && JSON.parse(storedUser)) ?? '')

  const loading = ref<boolean>(false)

  const getCSRFToken = async () => {
    await api.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_API_WEB_URL
    })
  }

  const authenticatedUser = async () => {
    const res = await api.get('user')

    if (res?.status === RESPONSE.OK) {
      user.value = res?.data
    }
  }

  /**
   * setFieldError appears to be an anti-pattern in vue
   * but there are some caveats when using vee-validate
   * which ends up doing this way.
   */
  const login = async (
    form: UserLogin,
    setFieldError: (key: keyof UserLogin, message: string) => void
  ) => {
    loading.value = true
    const { status, data } = await api.post('login', form,
      { baseURL: import.meta.env.VITE_API_WEB_URL }
    )
    loading.value = false

    if (status === RESPONSE.UNPROCESSABLE_ENTITY) {
      setFieldError('email', data?.errors?.email[0])
      return;
    }

    if (status === RESPONSE.OK) {
      localStorage.setItem('user', JSON.stringify(data))
      user.value = data

      toast.success(`Welcome back, ${data.last_name}!`)
      return router.replace({ name: ROUTE.DASHBOARD })
    }

    authenticatedUser()
  }

  const logout = async () => {
    loading.value = true
    const { status } = await api.post('logout', null, {
      baseURL: import.meta.env.VITE_API_WEB_URL
    })

    loading.value = false

    if (status === RESPONSE.NO_CONTENT) {
      localStorage.removeItem('user')
      return router.replace({ name: ROUTE.LOGIN })
    }
  }

  return {
    authenticatedUser,
    getCSRFToken,
    user,
    loading,
    login,
    logout
  }
})
