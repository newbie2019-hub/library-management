<script setup lang="ts">
import { ref, watch } from 'vue'
import { useAuthorStore } from '../store/authors'
import { actions, headers } from '../constants/authors'
import debounce from 'lodash.debounce'
import DataTable from '@/components/ui/data-table/DataTable.vue'
import FacetedFilter from '@/components/ui/data-table/filter/FacetedFilter.vue'
import DropdownOptions from '@/components/ui/data-table/DropdownOptions.vue'
import ConfirmModal from '@/components/ui/dialog/modal/ConfirmModal.vue'
import type { Book } from '@/@types/api/books'
import { useLoading } from '@/composables/useLoading'
import { LOADING } from '@/constants/loading'
import { Button } from '@/components/ui/button'
import { Icon } from '@iconify/vue'
import type { TableAction } from '@/@types/table-filters'
import type { Category } from '@/@types/api/category'

const loading = useLoading()
const store = useAuthorStore()

const fetchData = async () => {
  await store.getData()
}

const selectedCategory = ref<Category | null>(null)

const addUpdateModal = ref<boolean>(false)
const restoreModal = ref<boolean>(false)
const deleteModal = ref<boolean>(false)

const setAction = (category: Category, action: TableAction) => {
  selectedCategory.value = category

  if (action === 'delete') {
    deleteModal.value = true
  }

  if (action === 'update') {
    addUpdateModal.value = true
  }

  if (action === 'restore') {
    restoreModal.value = true
  }
}

const restoreCategory = async () => {
  if (!selectedCategory.value) return

  await store.restore(selectedCategory.value.id)
  restoreModal.value = false
  await store.getData()
}

const deleteCategory = async () => {
  if (!selectedCategory.value) return

  await store.destroy(selectedCategory.value.id)
  deleteModal.value = false
  await store.getData()
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
    :items="store.authors?.data"
    striped
    filterClass="justify-between"
    server-side-request
    :loading="loading.isLoading(LOADING.FETCH_AUTHORS)"
    :pagination-config="{
      per_side: 1,
      total: store.authors?.total!
    }"
    :caption="`Showing ${store.authors?.from ?? 0} to ${
      store.authors?.to ?? 0
    } out of ${store.authors?.total} authors`"
  >
    <template #additional-filters>
      <div class="flex gap-2.5 w-full md:w-fit">
        <Button
          variant="outline"
          class="text-xs"
        >
          <Icon icon="mdi:add-circle-outline" />
          New Author</Button
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
      </div>
    </template>
    <template #col-id="{ index }">
      {{ store.authors?.from! + index }}
    </template>
    <template #col-options="{ data }">
      <div class="flex">
        <DropdownOptions
          :options="actions"
          :is-deleted="(data as Book).deleted_at"
          @select="(action: TableAction) => setAction(data as Category, action)"
        />
      </div>
    </template>
  </DataTable>
  <ConfirmModal
    v-model="deleteModal"
    title="Confirm Delete"
    description="Are you sure you want to delete this author? This will also remove any association with a book. Please be certain."
    confirm-text="Delete Author"
    confirm-variant="destructive"
    :loading="loading.isLoading(LOADING.DELETE_AUTHOR)"
    @confirm="deleteCategory"
  ></ConfirmModal>
  <ConfirmModal
    v-model="restoreModal"
    title="Confirm Restore"
    description="Are you sure you want to restore this author? Unfortunately this wont associate any previously removed books"
    confirm-text="Restore Author"
    confirm-variant="default"
    :loading="loading.isLoading(LOADING.RESTORE_AUTHOR)"
    @confirm="restoreCategory"
  ></ConfirmModal>
</template>
