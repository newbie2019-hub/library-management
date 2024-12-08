<script setup lang="ts">
import CardSummary from '../../../components/ui/card/CardSummary.vue';
import type { BookSummary } from '@/@types/api/books';

defineProps<{
  loading?: boolean
  summary?: BookSummary
}>()
</script>

<template>
  <div class="flex flex-wrap md:flex-nowrap gap-3.5 w-full">
    <CardSummary
      title="Books"
      description="Distinct total books"
      icon="mdi:book-heart-outline"
      :value="+summary?.total_books!"
      :loading
    />
    <CardSummary
      title="Uncategorized"
      description="Books with no category"
      icon="mdi:user-heart-outline"
      :value="+summary?.uncategorized!"
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
      title="Unreturned Books"
      description="As of this date"
      icon="mdi:book-clock-outline"
      :value="+summary?.unreturnedBooks!"
      :loading
    />
  </div>
</template>