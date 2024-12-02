<script setup lang="ts">
import GlobalCommandDialog from '../command/GlobalCommandDialog.vue';
import DarkMode from '../darkmode-toggle/DarkMode.vue';
</script>

<template>
  <nav class="sticky top-0 left-0 w-full border-b z-10 bg-white/70 dark:bg-[var(--background)] backdrop-blur-md">
    <div class="justify-between flex px-4 py-4">
      <GlobalCommandDialog />
      <DarkMode />
    </div>
  </nav>
</template>