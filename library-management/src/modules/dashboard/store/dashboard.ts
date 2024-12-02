import { ref } from 'vue'
import { defineStore } from 'pinia'
import { api } from '@/lib/api'
import { RESPONSE } from '@/@types/status'
import type { Dashboard } from '@/@types/api/dashboard'

export const useDashboard = defineStore('dashboard', () => {
  const loading = ref<boolean>(true)
  const dashboard = ref<Dashboard | null>(null);

  const getData = async () => {
    loading.value = true
    const { data, status } = await api.get('dashboard')

    loading.value = false

    if (status === RESPONSE.SUCCESS) {
      dashboard.value = data
    }
  }

  return { dashboard, getData }
})
