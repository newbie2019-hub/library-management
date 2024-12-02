<script setup lang="ts">
import { RouterView } from 'vue-router'
import { Toaster } from 'vue-sonner';
import { onBeforeMount } from 'vue';
import { useAuthStore } from './modules/auth/store/auth';

const { authenticatedUser } = useAuthStore()

onBeforeMount(
  async () => {
    await authenticatedUser()
  }
)
</script>

<template>
  <RouterView />
  <Toaster position="top-right" rich-colors/>
</template>
