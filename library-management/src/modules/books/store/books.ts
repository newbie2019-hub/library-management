import { ref } from 'vue'
import { defineStore } from 'pinia'
import { api } from '@/lib/api'
import { RESPONSE } from '@/@types/status'
import type { BookFilters, IncludedQtyType } from '@/@types/table-filters'
import type { BookSaved, Books, BookSummary } from '@/@types/api/books'
import { toast } from 'vue-sonner'
import type { Book } from '@/@types/schema/book'
import { useLoading } from '@/composables/useLoading'
import { LOADING } from '@/constants/loading'

const ENDPOINT = 'books';

export const useBooks = defineStore('books', () => {
  //Loading handler
  const loading = useLoading()

  const books = ref<Books | null>(null);

  const search = ref<string>('')
  const additionalFilters = ref<BookFilters>({
    category: '',
    included_quantity: '',
    include_record: '',
    per_page: 15,
    page: 1
  })

  const summary = ref<BookSummary>({
    total_books: 0,
    uncategorized: 0,
    unreturnedBooks: 0,
    categories_count: 0
  })

  const getData = async (isSearching?: boolean) => {
    loading.setLoading(LOADING.FETCH_BOOK)
    //If from search reset the page
    if (isSearching) {
      additionalFilters.value.page = 1
    }

    const { data, status } = await api.get<Books>(ENDPOINT, {
      params: { search: search.value, ...additionalFilters.value}
    })

    loading.removeLoading(LOADING.FETCH_BOOK)

    if (status === RESPONSE.OK) {
      console.log('Data: ', data)
      books.value = data
    }
  }

  const getSummary = async () => {
    loading.setLoading(LOADING.BOOK_SUMMARY)
    const { data, status } = await api.get<BookSummary>(`${ENDPOINT}/summary`)
    loading.removeLoading(LOADING.BOOK_SUMMARY)

    if (status === RESPONSE.OK) {
      summary.value = data
    }
  }

  const store = async (book: Book): Promise<boolean> => {
    loading.setLoading(LOADING.ADD_BOOK)
    const { data, status } = await api.post<BookSaved>(`${ENDPOINT}`, book)
    loading.removeLoading(LOADING.ADD_BOOK)

    if (status === RESPONSE.OK) {
      await getData() //Retrieve new data
      toast.success(data.message!)
      return true
    }

    return false
  }

  const update = async (id: string, book: Book): Promise<boolean | undefined> => {
    loading.setLoading(LOADING.UPDATE_BOOK)
    const { data, status } = await api.put<BookSaved>(`${ENDPOINT}/${id}`, book)
    loading.removeLoading(LOADING.UPDATE_BOOK)

    if (status === RESPONSE.OK) {
      //Update book data
      const bookIndex = books.value?.data.findIndex(b => b.id === id)
      books.value!.data[bookIndex!] = data.data

      toast.success(data.message!);
      return true
    }
  }


  const destroy = async (id: string) => {
    loading.setLoading(LOADING.DELETE_BOOK)
    const { data, status } = await api.delete<{message: string}>(`${ENDPOINT}/${id}`)
    loading.removeLoading(LOADING.DELETE_BOOK)

    if (status === RESPONSE.OK) {
      toast.success(data.message);
    }
  }

  const restore = async (id: string) => {
    loading.setLoading(LOADING.RESTORE_BOOK)
    const { data, status } = await api.put<{message: string}>(`${ENDPOINT}/${id}/restore`)
    loading.removeLoading(LOADING.RESTORE_BOOK)

    if (status === RESPONSE.OK) {
      toast.success(data.message);
    }
  }

  return {
    additionalFilters,
    books,
    summary,
    getData,
    getSummary,
    restore,
    store,
    search,
    update,
    destroy
  }
})
