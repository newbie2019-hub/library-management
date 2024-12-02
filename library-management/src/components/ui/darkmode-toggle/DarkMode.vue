<script setup lang="ts">
import { Icon } from '@iconify/vue/dist/iconify.js';
import { useDark, useToggle } from '@vueuse/core'

const isDarkMode = useDark()
const toggleDark = useToggle(isDarkMode)
</script>

<template>
  <div class="hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer shrink-0 p-1.5 rounded-full">
    <Icon
      @click="() => toggleDark(!isDarkMode)"
      :icon="isDarkMode ?
        'mdi:moon-and-stars' :
        'mdi:weather-sunny'"
      :width="20"
    />
  </div>
</template>