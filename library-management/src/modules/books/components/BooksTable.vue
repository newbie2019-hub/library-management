<script setup lang="ts">
import { useBooks } from '../store/books'
import { actions, headers } from '../constants/books'
import { ref, watch } from 'vue'
import debounce from 'lodash.debounce'
import DataTable from '@/components/ui/data-table/DataTable.vue'
import FacetedFilter from '@/components/ui/data-table/filter/FacetedFilter.vue'
import { Badge } from '@/components/ui/badge'
import DropdownOptions from '@/components/ui/data-table/DropdownOptions.vue'
import ConfirmModal from '@/components/ui/dialog/modal/ConfirmModal.vue'
import type { Book } from '@/@types/api/books'
import type { Book as BookSchema } from '@/@types/schema/book'
import UpdateBook from './AddUpdateBook.vue'
import { useLoading } from '@/composables/useLoading'
import { LOADING } from '@/constants/loading'
import AddUpdateBook from './AddUpdateBook.vue'
import { Button } from '@/components/ui/button'
import { Icon } from '@iconify/vue'
import type { TableAction } from '@/@types/table-filters'

const loading = useLoading()
const store = useBooks()

const fetchData = async () => {
  await store.getData()
}

const actionType = ref<'add' | 'update'>('add')
const selectedBook = ref<Book | null>(null)
const updateModal = ref<boolean>(false)
const restoreModal = ref<boolean>(false)
const deleteModal = ref<boolean>(false)

const updateBookRef = ref<InstanceType<typeof UpdateBook> | null>(null)

const setAction = (book: Book, action: TableAction) => {
  selectedBook.value = book

  if (action === 'delete') {
    deleteModal.value = true
  }

  if (action === 'update') {
    actionType.value = 'update'
    updateBookRef.value?.form.setValues({
      ...book,
      categories: book.categories.map((categ) => categ.id),
      author_id: book.author?.id,
    })
    updateModal.value = true
  }

  if (action === 'restore') {
    restoreModal.value = true
  }
}

const handleNewBook = () => {
  actionType.value = 'add'
  updateBookRef.value?.form.resetForm()
  updateModal.value = true
}

const restoreBook = async () => {
  if (!selectedBook.value) return

  await store.restore(selectedBook.value.id)
  restoreModal.value = false
  await store.getData()
}

const deleteBook = async () => {
  if (!selectedBook.value) return

  await store.destroy(selectedBook.value.id)
  deleteModal.value = false
  await store.getData()
}

const handleConfirmAction = async (book: BookSchema) => {
  if (actionType.value === 'add') {
    const success = await store.store(book)
    if (success) {
      updateModal.value = false
    }
  }

  if (actionType.value === 'update') {
    const success = await store.update(selectedBook.value?.id!, book)
    if (success) {
      updateModal.value = false
    }
  }
}

watch(
  () => store.additionalFilters,
  debounce(async () => {
    await fetchData()
  }, 300),
  { deep: true },
)

watch(
  () => store.search,
  debounce(async () => {
    await store.getData(true)
  }, 300),
)
</script>

<template>
  <DataTable
    v-model:search="store.search"
    v-model:per-page="store.additionalFilters.per_page"
    v-model:page="store.additionalFilters.page"
    :headers
    :items="store.books?.data"
    striped
    filterClass="justify-between"
    server-side-request
    :loading="loading.isLoading(LOADING.FETCH_BOOK)"
    :pagination-config="{
      per_side: 1,
      total: store.books?.total!
    }"
    :caption="`Showing ${store.books?.from ?? 0} to ${
      store.books?.to ?? 0
    } out of ${store.books?.total} books`"
  >
    <template #additional-filters>
      <div class="flex gap-2.5 w-full md:w-fit">
        <Button
          variant="outline"
          @click="handleNewBook"
          class="text-xs"
        >
          <Icon icon="mdi:add-circle-outline" />
          New Book</Button
        >
        <FacetedFilter
          v-model="store.additionalFilters.include_record"
          btnLabel="Includes"
          optionLabel="Filter By"
          :options="[
            { label: 'Deleted', value: 'only_trashed' },
            { label: 'With Deleted', value: 'with_trashed' },
            { label: 'Exclude Deleted', value: '' },
          ]"
        />
        <FacetedFilter
          v-model="store.additionalFilters.category"
          btnLabel="Category"
          optionLabel="Filter By"
          :options="[
            { label: 'Categorized', value: 'categorized' },
            { label: 'Uncategorized', value: 'uncategorized' },
          ]"
        />
        <FacetedFilter
          v-model="store.additionalFilters.included_quantity"
          btnLabel="Quantity"
          optionLabel="Filter By"
          :options="[
            { label: 'Out of Stock', value: 'out_of_stock' },
            { label: 'With Stocks', value: 'with_stocks' },
          ]"
        />
      </div>
    </template>
    <template #col-id="{ index }">
      <div class="flex justify-center">
        {{ store.books?.from! + index }}
      </div>
    </template>
    <template #col-categories="{ data }">
      <div class="flex gap-x-1.5">
        <Badge
          variant="secondary"
          v-for="category in data.categories.slice(0, 2)"
          :key="category.id"
          class="font-normal"
        >
          {{ category.category }}
        </Badge>
        <Badge variant="secondary"> +{{ data.categories.length }} </Badge>
      </div>
    </template>
    <template #col-options="{ data }">
      <div class="flex justify-center">
        <DropdownOptions
          :options="actions"
          :is-deleted="(data as Book).deleted_at"
          @select="(action: TableAction) => setAction(data as Book, action)"
        />
      </div>
    </template>
  </DataTable>
  <ConfirmModal
    v-model="deleteModal"
    title="Confirm Delete"
    description="Are you sure you want to delete this book? This will also delete any related records."
    confirm-text="Delete Book"
    confirm-variant="destructive"
    :loading="loading.isLoading(LOADING.DELETE_BOOK)"
    @confirm="deleteBook"
  ></ConfirmModal>
  <ConfirmModal
    v-model="restoreModal"
    title="Confirm Restore"
    description="Are you sure you want to restore this book? This will also restore any related records."
    confirm-text="Restore Book"
    confirm-variant="ghost"
    :loading="loading.isLoading(LOADING.RESTORE_BOOK)"
    @confirm="restoreBook"
  ></ConfirmModal>
  <AddUpdateBook
    ref="updateBookRef"
    :type="actionType"
    v-model="updateModal"
    :loading="loading.isLoading(LOADING.UPDATE_BOOK)"
    @confirm-action="handleConfirmAction"
  />
</template>
