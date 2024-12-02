<script setup lang="ts">
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Icon } from '@iconify/vue/dist/iconify.js';
import SkeletonLoader from '@/components/ui/card/SkeletonLoader.vue';
import { vAutoAnimate } from '@formkit/auto-animate'

defineProps<{
  title: string;
  icon?: string
  value?: number | null;
  description: string;
  loading?: boolean
}>()
</script>

<template>
  <Card class="md:max-w-sm w-full" v-auto-animate>
    <CardHeader v-if="!loading" class="px-6 pb-0 pt-5">
      <CardTitle class="text-xl flex justify-between">
        <span class="text-sm font-normal">{{ title }}</span>
        <Icon
          v-if="icon"
          :icon="icon"
          :width="15"
          class="text-gray-500 dark:text-gray-300"
        />
      </CardTitle>
    </CardHeader>
    <CardContent class="px-6 pb-5">
      <SkeletonLoader v-if="loading" class="mt-5"/>
      <div v-else class="mt-2" >
        <p class="text-2xl font-medium">
          {{ value }}
        </p>
        <p class="text-xs text-gray-600 dark:text-gray-400 font-light">
          {{ description }}
        </p>
      </div>
    </CardContent>
  </Card>
</template>