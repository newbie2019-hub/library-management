import { ref } from 'vue'
import { defineStore } from 'pinia'
import { api } from '@/lib/api'
import { RESPONSE } from '@/@types/status'
import type { BookFilters, IncludedQtyType } from '@/@types/table-filters'
import type { Books } from '@/@types/api/books'
import { toast } from 'vue-sonner'
import { useLoading } from '@/composables/useLoading'
import { LOADING } from '@/constants/loading'
import { API } from '@/constants/endpoints'
import type { Author } from '@/@types/api/authors'

const ENDPOINT = API.AUTHORS;

export const useAuthorStore = defineStore('authors', () => {
  //Loading handler
  const loading = useLoading()

  const allAuthors = ref<Author[] | null>(null);
  //Paginated
  const authors = ref<Books | null>(null);

  const search = ref<string>('')
  const additionalFilters = ref<BookFilters>({
    per_page: 15,
    page: 1
  })

  const getData = async (isSearching?: boolean) => {
    loading.setLoading(LOADING.FETCH_AUTHORS)
    //If from search reset the page
    if (isSearching) {
      additionalFilters.value.page = 1
    }

    const { data, status } = await api.get<Books>(ENDPOINT, {
      params: { search: search.value, ...additionalFilters.value}
    })

    loading.removeLoading(LOADING.FETCH_AUTHORS)

    if (status === RESPONSE.OK) {
      authors.value = data
    }
  }

  const getAllAuthors = async () => {
    const { data, status } = await api.get<Author[]>(`${ENDPOINT}/all`)

    if (status === RESPONSE.OK) {
      allAuthors.value = data
    }
  }

  const store = async (form: Author) => {
    const { data, status } = await api.post(`${ENDPOINT}`, form)

    if (status === RESPONSE.OK) {
      toast.success(data.message)
    }
  }

  const update = async (id: string, form: Author) => {
    const { data, status } = await api.put(`${ENDPOINT}/${id}`)

    if (status === RESPONSE.OK) {
      const index = authors.value?.data.findIndex(author => author.id === id)
      authors.value!.data[index!] = data.data

      toast.success(data.message)
      return true
    }
  }

  const destroy = async (id: string) => {
    loading.setLoading(LOADING.DELETE_AUTHOR)
    const { data, status } = await api.delete<{message: string}>(`${ENDPOINT}/${id}`)
    loading.removeLoading(LOADING.DELETE_AUTHOR)

    if (status === RESPONSE.OK) {
      toast.success(data.message);
    }
  }

  const restore = async (id: string) => {
    loading.setLoading(LOADING.RESTORE_AUTHOR)
    const { data, status } = await api.put<{message: string}>(`${ENDPOINT}/${id}/restore`)
    loading.removeLoading(LOADING.RESTORE_AUTHOR)

    if (status === RESPONSE.OK) {
      toast.success(data.message);
    }
  }

  return {
    allAuthors,
    additionalFilters,
    authors,
    getData,
    getAllAuthors,
    restore,
    store,
    search,
    update,
    destroy
  }
})
