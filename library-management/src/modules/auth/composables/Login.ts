import { RESPONSE } from "@/@types/status"
import { api } from "@/lib/api"
import { useMutation } from "@tanstack/vue-query"
import type { UserLogin } from "../schema/auth"

export function Login() {

  const login = async (form: UserLogin) => {
    const res = await api.post('login')

    if (res.status === RESPONSE.SUCCESS) {
      return res.data
    }

    return null
  }

  const { error, mutate, reset } = useMutation({
    mutationKey: ['login'],
    mutationFn: login
  })

  const authenticate = (form: UserLogin) => {
    mutate(form)
  }

  return {}
}