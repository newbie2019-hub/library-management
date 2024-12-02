<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import type { User } from '@/@types/api/user';

defineProps<{
  collapsed: boolean;
  user: User | undefined
}>()
</script>

<template>
  <div
    class="flex gap-x-2.5 items-center justify-center py-3.5"
    :class="{'px-4': !collapsed}"
  >
    <Avatar>
      <AvatarImage
        :src="`https://robohash.org/${user?.first_name}`"
        :alt="`${user?.first_name}`"
      />
      <AvatarFallback>
        {{ user?.first_name[0] }} {{ user?.last_name[0] }}
      </AvatarFallback>
    </Avatar>
    <div v-if="!collapsed" class="w-32">
      <p class="text-sm text-nowrap truncate text-ellipsis">
        {{ user?.first_name }} {{ user?.last_name }}
      </p>
      <p class="text-gray-600 dark:text-gray-400 text-xs truncate text-ellipsis">
        {{ user?.email }}
      </p>
    </div>
  </div>
</template>