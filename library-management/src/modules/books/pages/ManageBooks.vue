<script setup lang="ts">
import { onBeforeMount } from 'vue'
import { useBooks } from '../store/books'
import BookSummary from '../components/BookSummary.vue'
import BooksTable from '../components/BooksTable.vue'
import { useLoading } from '@/composables/useLoading'
import { LOADING } from '@/constants/loading'
import { useAuthorStore } from '@/modules/author/store/authors'

const loading = useLoading()
const store = useBooks()
const { getAllAuthors } = useAuthorStore()

onBeforeMount(async () => {
  Promise.all([getAllAuthors(), store.getData(), store.getSummary()])
})
</script>

<template>
  <div class="flex flex-col gap-4 pb-5">
    <div class="mb-4">
      <h1 class="text-xl font-medium mb-4">Books</h1>
      <BookSummary
        :summary="store.summary"
        :loading="loading.isLoading(LOADING.BOOK_SUMMARY)"
      />
    </div>
    <BooksTable />
  </div>
</template>
