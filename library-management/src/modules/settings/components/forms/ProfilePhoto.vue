<script setup lang="ts">
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
import { useAuthStore } from '@/modules/auth/store/auth';

const store = useAuthStore()
</script>

<template>
  <div class="flex">
    <Avatar size="lg">
      <AvatarImage
        :src="`https://robohash.org/${store.user?.first_name}-${store.user?.last_name}`"
        :alt="`${store.user?.first_name}-${store.user?.last_name}`"
        class="pl-2"
      />
      <AvatarFallback>
        {{ store.user?.first_name[0] }} {{ store.user?.last_name[0] }}
      </AvatarFallback>
    </Avatar>
  </div>
</template>