<script setup lang="ts">
import SidebarItem from '@/components/ui/sidebar/SidebarItem.vue';
import { routes } from '@/constants/routes';

defineProps<{
  collapsed: boolean
}>()
</script>

<template>
  <div id="sidebar-options" class="pb-8 pt-4 px-3">
    <p
      class="text-sm mb-3 text-gray-700 dark:text-gray-400"
      :class="collapsed ? 'text-center' : 'ml-2'"
    >
      Menu
    </p>
    <div class="flex flex-col gap-1.5">
      <SidebarItem
        v-for="route in routes"
        :key="route.label"
        :path="route.path"
        :icon="route.icon"
        :label="route.label"
        :collapsed="collapsed"
        rounded
      />
    </div>
  </div>
</template>