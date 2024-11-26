<script setup lang="ts">
import { Icon } from '@iconify/vue';
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger
} from '@/components/ui/tooltip'
import type { RouteLocationRaw } from 'vue-router';

defineProps<{
  path: RouteLocationRaw
  icon: string
  label: string
  rounded?: boolean
  collapsed?: boolean
}>()
</script>

<template>
  <TooltipProvider
    :delay-duration="300"
    :disabled="!collapsed"
  >
    <Tooltip>
      <TooltipTrigger class="w-full">
        <RouterLink
          :to="path"
          class="link"
          :class="[
            {'rounded-md': rounded},
            {'px-3.5': !collapsed},
            {'justify-center': collapsed}
          ]"
        >
          <Icon :icon="icon" />
          <span v-if="!collapsed" class="text-sm">{{ label }}</span>
        </RouterLink>
      </TooltipTrigger>
      <TooltipContent side="right">
        <p>{{ label }}</p>
      </TooltipContent>
    </Tooltip>
  </TooltipProvider>

</template>

<style>
.router-link-exact-active {
  @apply bg-gray-200 text-gray-900
}

.link {
  @apply flex transition-all duration-100 ease-in-out items-center gap-x-2.5 py-2 text-gray-600 hover:bg-gray-100
}
</style>