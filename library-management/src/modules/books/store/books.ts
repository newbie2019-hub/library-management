import { ref } from 'vue'
import { defineStore } from 'pinia'
import { api } from '@/lib/api'
import { RESPONSE } from '@/@types/status'
import type { BookFilters } from '@/@types/table-filters'
import type { Books, BookSummary } from '@/@types/api/books'

const ENDPOINT = 'books';

export const useBooks = defineStore('books', () => {
  const loading = ref<boolean>(true)
  const books = ref<Books | null>(null);
  const summary = ref<BookSummary>({
    total_books: 0,
    uncategorized: 0,
    unreturnedBooks: 0,
    categories_count: 0
  })

  const getData = async (filters?: BookFilters) => {
    loading.value = true
    const { data, status } = await api.get<Books>(ENDPOINT, {
      params: filters
    })

    loading.value = false

    if (status === RESPONSE.SUCCESS) {
      books.value = data
    }
  }

  const getSummary = async () => {
    loading.value = true
    const { data, status } = await api.get<BookSummary>(`${ENDPOINT}/summary`)
    loading.value = false

    if (status === RESPONSE.SUCCESS) {
      summary.value = data
    }
  }

  const store = async () => {
    //
  }

  const update = async () => {
    //
  }

  const destroy = async () => {
    //
  }

  return { books, summary, getData, getSummary, store, update, destroy }
})
