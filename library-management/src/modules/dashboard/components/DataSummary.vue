<script setup lang="ts">
import { inject } from 'vue';
import CardSummary from '../../../components/ui/card/CardSummary.vue';
import { dashboardKey } from '@/@types/injection-key/dashboard';

defineProps<{
  loading?: boolean
}>()

const summary = inject(dashboardKey)
</script>

<template>
  <div class="flex flex-wrap md:flex-nowrap gap-3.5 w-full">
    <CardSummary
      title="Books"
      description="10 books have been added"
      icon="mdi:book-heart-outline"
      :value="+summary?.book_count!"
      :loading
    />
    <CardSummary
      title="Authors"
      description="No new authors"
      icon="mdi:user-heart-outline"
      :value="+summary?.author_count!"
      :loading
    />
    <CardSummary
      title="Categories"
      description="1 category has been added"
      icon="mdi:bookmark-multiple-outline"
      :value="+summary?.categories_count!"
      :loading
    />
    <CardSummary
      title="Issued Books"
      description="4 books have been newly issued"
      icon="mdi:book-clock-outline"
      :value="+summary?.issued_book_count!"
      :loading
    />
  </div>
</template>