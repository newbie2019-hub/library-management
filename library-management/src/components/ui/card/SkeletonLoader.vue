<script setup lang="ts">
import { Skeleton } from '@/components/ui/skeleton';
</script>

<template>
  <div class="">
    <div class="flex justify-between items-center w-full">
      <Skeleton class="h-2.5 w-20" />
      <Skeleton class="h-5 w-5 rounded-full shrink-0" />
    </div>
    <div class="mt-4">
      <Skeleton class="h-6 w-16" />
      <Skeleton class="h-2 w-32 mt-1.5" />
    </div>
  </div>
</template>