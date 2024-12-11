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
import type { Categories, Category as CategoryApi } from '@/@types/api/category'
import type { Category } from '@/@types/schema/categories'

const ENDPOINT = API.CATEGORIES;

export const useCategoryStore = defineStore('categories', () => {
  //Loading handler
  const loading = useLoading()

  const allCategories = ref<CategoryApi[] | null>(null);
  //Paginated
  const categories = ref<Categories | null>(null);

  const search = ref<string>('')
  const additionalFilters = ref<BookFilters>({
    per_page: '15',
    page: 1
  })

  const getData = async (isSearching?: boolean) => {
    loading.setLoading(LOADING.FETCH_CATEGORIES)
    //If from search reset the page
    if (isSearching) {
      additionalFilters.value.page = 1
    }

    const { data, status } = await api.get<Categories>(ENDPOINT, {
      params: { search: search.value, ...additionalFilters.value}
    })

    loading.removeLoading(LOADING.FETCH_CATEGORIES)

    if (status === RESPONSE.OK) {
      categories.value = data
    }
  }

  const getAllCategories = async () => {
    const { data, status } = await api.get<CategoryApi[]>(`${ENDPOINT}/all`)

    if (status === RESPONSE.OK) {
      allCategories.value = data
    }
  }

  const store = async (form: Category): Promise<boolean | undefined> => {
    loading.setLoading(LOADING.ADD_CATEGORY)
    const { data, status } = await api.post(`${ENDPOINT}`, form)
    loading.removeLoading(LOADING.ADD_CATEGORY)

    if (status === RESPONSE.OK) {
      toast.success(data.message)
      return true
    }

    console.log('Data: ', data)
  }

  const update = async (id: string, form: Category): Promise<boolean | undefined> => {
    loading.setLoading(LOADING.FETCH_CATEGORIES)
    const { data, status } = await api.put<ApiSuccess<CategoryApi>>(`${ENDPOINT}/${id}`, form)
    loading.removeLoading(LOADING.FETCH_CATEGORIES)

    if (status === RESPONSE.OK) {
      const index = categories.value?.data.findIndex(categ => categ.id === id)
      categories.value!.data[index!] = data.data

      toast.success(data.message)
      return true
    }

    console.log('Data: ', data)
  }

  const destroy = async (id: string) => {
    loading.setLoading(LOADING.DELETE_CATEGORY)
    const { data, status } = await api.delete<{message: string}>(`${ENDPOINT}/${id}`)
    loading.removeLoading(LOADING.DELETE_CATEGORY)

    if (status === RESPONSE.OK) {
      toast.success(data.message);
    }
  }

  const restore = async (id: string) => {
    loading.setLoading(LOADING.RESTORE_CATEGORY)
    const { data, status } = await api.put<{message: string}>(`${ENDPOINT}/${id}/restore`)
    loading.removeLoading(LOADING.RESTORE_CATEGORY)

    if (status === RESPONSE.OK) {
      toast.success(data.message);
    }
  }

  return {
    allCategories,
    additionalFilters,
    categories,
    getData,
    getAllCategories,
    restore,
    store,
    search,
    update,
    destroy
  }
})
