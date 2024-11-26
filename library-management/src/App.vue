<script setup lang="ts">
import { RouterView } from 'vue-router'
import { Toaster } from 'vue-sonner';
import { onBeforeMount, onMounted, provide, type InjectionKey } from 'vue';
import { userKey } from './@types/injection-key';
import { useAuthStore } from './modules/auth/store/auth';

const store = useAuthStore()

provide(userKey, store.user)

onBeforeMount(
  async () => {
    await store.authenticatedUser()
  }
)
</script>

<template>
  <RouterView />
  <Toaster position="top-right" rich-colors/>
</template>
