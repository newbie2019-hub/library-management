<script setup lang="ts">
import { onBeforeMount, ref, watch } from 'vue';
import debounce from 'lodash.debounce'
import { useBooks } from '../store/books';
import BookSummary from '../components/BookSummary.vue';
import type { TableFilters } from '@/@types/components/data-table';
import type { CategoryFilterType, IncludedQtyType } from '@/@types/table-filters';
import BooksTable from '../components/BooksTable.vue';

const store = useBooks()

onBeforeMount(
  async () => {
    Promise.all([store.getData(), store.getSummary()])
  }
)
</script>

<template>
  <div class="flex flex-col gap-4 pb-5">
    <div class="mb-4">
      <h1 class="text-xl font-medium mb-4">
        Books
      </h1>
      <BookSummary :summary="store.summary" />
    </div>
    <BooksTable />
  </div>
</template>