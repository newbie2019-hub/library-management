<script setup lang="ts">
import { ref, watch } from 'vue'
import { useCategoryStore } from '../store/categories'
import { actions, headers } from '../constants/categories'
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
import type { Category as CategoryApi } from '@/@types/api/category'
import AddUpdateCategory from './AddUpdateCategory.vue'
import type { Category } from '@/@types/schema/categories'

const loading = useLoading()
const store = useCategoryStore()

const fetchData = async () => {
  await store.getData()
}

const selectedCategory = ref<CategoryApi | null>(null)

const addUpdateRef = ref<InstanceType<typeof AddUpdateCategory> | null>(null)

const actionType = ref<'add' | 'update'>('add')
const addUpdateModal = ref<boolean>(false)
const restoreModal = ref<boolean>(false)
const deleteModal = ref<boolean>(false)

const setAction = (category: CategoryApi, action: TableAction) => {
  selectedCategory.value = category

  if (action === 'delete') {
    deleteModal.value = true
  }

  if (action === 'update') {
    addUpdateRef.value?.form.setFieldValue('category', category.category)
    actionType.value = 'update'
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

const setAddCategory = () => {
  actionType.value = 'add'
  addUpdateModal.value = true
}

const handleConfirm = async (category: Category) => {
  if (actionType.value === 'add') {
    const success = await store.store(category)
    closeModal(success, 'eom')
  }

  if (actionType.value === 'update') {
    const response = await store.update(selectedCategory.value?.id!, category)
    closeModal(response, 'Something went wrong')
  }
}

const closeModal = (status: boolean | undefined, errorMessage?: string) => {
  if (!status && errorMessage) {
    addUpdateRef.value?.form.setFieldError('category', errorMessage)
    return
  }

  addUpdateModal.value = false
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
    :items="store.categories?.data"
    striped
    filterClass="justify-between"
    server-side-request
    :loading="loading.isLoading(LOADING.FETCH_CATEGORIES)"
    :pagination-config="{
      per_side: 1,
      total: store.categories?.total!
    }"
    :caption="`Showing ${store.categories?.from ?? 0} to ${
      store.categories?.to ?? 0
    } out of ${store.categories?.total} categories`"
  >
    <template #additional-filters>
      <div class="flex gap-2.5 w-full md:w-fit">
        <Button
          variant="outline"
          class="text-xs"
          @click="setAddCategory"
        >
          <Icon icon="mdi:add-circle-outline" />
          New Category</Button
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
      {{ store.categories?.from! + index }}
    </template>
    <template #col-options="{ data }">
      <div class="flex">
        <DropdownOptions
          :options="actions"
          :is-deleted="(data as Book).deleted_at"
          @select="(action: TableAction) => setAction(data as CategoryApi, action)"
        />
      </div>
    </template>
  </DataTable>
  <AddUpdateCategory
    ref="addUpdateRef"
    v-model="addUpdateModal"
    :type="actionType"
    @confirm-action="handleConfirm"
  />
  <ConfirmModal
    v-model="deleteModal"
    title="Confirm Delete"
    description="Are you sure you want to delete this category? This will also remove any association with a book. Please be certain."
    confirm-text="Delete Category"
    confirm-variant="destructive"
    :loading="loading.isLoading(LOADING.DELETE_CATEGORY)"
    @confirm="deleteCategory"
  ></ConfirmModal>
  <ConfirmModal
    v-model="restoreModal"
    title="Confirm Restore"
    description="Are you sure you want to restore this category? Unfortunately this wont associate any previously removed books"
    confirm-text="Restore Category"
    confirm-variant="default"
    :loading="loading.isLoading(LOADING.RESTORE_CATEGORY)"
    @confirm="restoreCategory"
  ></ConfirmModal>
</template>
