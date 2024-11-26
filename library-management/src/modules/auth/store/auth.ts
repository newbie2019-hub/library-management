import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { api } from '@/lib/api'
import { useForm } from 'vee-validate'
import { LoginSchema } from '../schema/auth'
import { RESPONSE } from '@/@types/status'
import { toast } from 'vue-sonner'
import router from '@/router'
import { ROUTE } from '@/@types/routes'

export const useAuthStore = defineStore('authentication', () => {
  const storedUser = localStorage.getItem('user')

  const user = ref((storedUser && JSON.parse(storedUser)) ?? '')
  const form = useForm({
    validationSchema: LoginSchema
  })

  const getCSRFToken = async () => {
    await api.get('sanctum/csrf-cookie', {
      baseURL: import.meta.env.VITE_API_WEB_URL
    })
  }

  const authenticatedUser = async () => {
    const { status, data } = await api.get('user')

    if (status === RESPONSE.SUCCESS) {
      user.value = data
    }
  }

  const login = form.handleSubmit(
    async (values, { resetForm, setFieldError }) => {
      const { status, data } = await api.post('login', values,
        { baseURL: import.meta.env.VITE_API_WEB_URL }
      )

      if (status === RESPONSE.UNPROCESSABLE_ENTITY) {
        setFieldError('email', data?.errors?.email[0])
        user.value = data
        return;
      }

      if (status === RESPONSE.SUCCESS) {
        localStorage.setItem('user', JSON.stringify(data))
        toast.success(`Welcome back, ${data.last_name}!`)
        return router.replace({ name: ROUTE.DASHBOARD })
      }

      authenticatedUser()
      resetForm()
    }
  )

  const logout = async () => {
    const { status } = await api.post('logout', null, {
      baseURL: import.meta.env.VITE_API_WEB_URL
    })

    if (status === RESPONSE.NO_CONTENT) {
      localStorage.removeItem('user')
      return router.replace({ name: ROUTE.LOGIN })
    }
  }

  return {
    authenticatedUser,
    user,
    login,
    logout
  }
})
