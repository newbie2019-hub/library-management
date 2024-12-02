import { defineStore } from "pinia";
import { ref } from "vue";

export const useSettingStore = defineStore('settings', () => {
  const personalInfoLoading = ref<boolean>(false)
  const accountInfoLoading = ref<boolean>(false)

  return {
    personalInfoLoading,
    accountInfoLoading,
  }
})