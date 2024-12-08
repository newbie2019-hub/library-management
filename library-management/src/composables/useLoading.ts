import { ref } from "vue"
import type { LOADING } from "@/constants/loading"

const loading = ref<string[]>([])

export function useLoading() {
  const setLoading = (key: typeof LOADING[keyof typeof LOADING]) => {
    if (loading.value.includes(key)) return
    loading.value.push(key)
  }

  const removeLoading = (key: typeof LOADING[keyof typeof LOADING]) => {
    const index = loading.value.indexOf(key)
    if (index === -1) return

    //Remove key from loading ref
    loading.value.splice(index, 1)
  }

  const isLoading = (key: typeof LOADING[keyof typeof LOADING]) => {
    return loading.value.includes(key)
  }

  return {
    loading,
    setLoading,
    removeLoading,
    isLoading
  }
}