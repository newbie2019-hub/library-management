<script setup lang="ts">
import { ref, watch, type HTMLAttributes } from 'vue';
import type { PaginationConfig, Sort, TableFilters, TableHeaderEmit, TableHeaders, TableItems } from '@/@types/components/data-table';
import RowHeader from './filter/RowHeader.vue';
import { computed } from '@vue/reactivity';
import ColumnFilter from './filter/ColumnFilter.vue';
import { Input } from '../input';
import { Icon } from '@iconify/vue';
import Pagination from '../pagination/Pagination.vue';
import debounce from 'lodash.debounce'
import PerPageOptions from './PerPageOptions.vue';

const props = defineProps<{
  caption?: string
  headers: TableHeaders[]
  items: TableItems | undefined
  striped?: boolean
  hideRowNumbers?: boolean
  filterClass?: HTMLAttributes['class']
  paginated?: boolean
  paginationConfig?: PaginationConfig
}>()

const emit = defineEmits<{
  (e: 'filters-change', data: TableFilters): void
}>()

type TableCol = TableHeaders & { shown: boolean, sort: Sort }

const tableFilters = ref<TableFilters>({
  search: '',
  sort: { column: '', order: 'none' },
  page: 1,
  per_page: 15
})

const columns = ref<TableCol[]>(
  props.headers.map(header => {
    return {...header, shown: true, sort: 'none'}
  })
)

const shownColumns = computed(
  () => columns.value.filter(col => col.shown)
)

const handleHeaderFilter = (data: TableHeaderEmit, col: TableCol) => {
  if (data.type === 'sort') {
    col.sort = data.value
  }
  if (data.type === 'visibility_change') {
    col.shown = false //Hide option from table header
  }
}

watch(
  () => tableFilters.value,
  debounce(() => {
    emit('filters-change', tableFilters.value)
  }, 300),
  { deep: true }
)
</script>

<template>
  <div>
    <div class="flex flex-wrap md:flex-nowrap justify-end items-center gap-2 mb-4" :class="filterClass">
      <slot name="additional-filters" />
      <div class="flex gap-2.5 w-full md:w-fit">
        <div class="relative items-center w-full md:w-72">
          <Input
            id="search"
            type="text"
            placeholder="Search..."
            class="pl-8 text-sm w-full"
            v-model="tableFilters.search"
          />
          <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
            <Icon icon="mdi:search" class="text-gray-600 shrink-0 ml-1" />
          </span>
        </div>
        <ColumnFilter
          label="Columns"
          heading="Toggle Visibility"
          icon="mdi:cog-outline"
          v-model="columns"
        />
      </div>
    </div>
    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-300">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900 dark:text-gray-300">
            <tr>
              <th v-if="!hideRowNumbers" class="px-6 py-3">
                #
              </th>
              <th
                v-for="col in shownColumns"
                :key="col.title"
                scope="col"
                class="text-left px-6 py-3"
              >
                <RowHeader
                  :label="col.title"
                  :sort="col.sort"
                  :class="col.class"
                  :sortable="col.sortable"
                  @change="(data) => handleHeaderFilter(data, col)"
                />
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-if="items?.length === 0"
              class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900"
            >
              <td :colspan="shownColumns.length" class="text-center py-4">
                No Data Found
              </td>
            </tr>
            <tr
              v-for="(row, i) in items"
              :key="row.id"
              class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900"
              :class="{'odd:bg-white odd:dark:bg-gray-950 even:bg-gray-50 even:dark:bg-gray-900': striped}"
            >
              <td v-if="!hideRowNumbers" class="row-cell">{{ i + 1 }}</td>
              <td
                v-for="(column, j) in shownColumns"
                :key="column.title + j"
                class="row-cell"
              >
                <slot :name="`col-${column.key}`" :data="row" :index="i">
                  {{ (typeof column.value === 'function' ?
                  column.value(row) : row[column?.key]) }}
                  <span
                    v-if="!(typeof column.value === 'function' ?
                      column.value(row) : row[column?.key])"
                    class="text-gray-500 text-xs"
                  >
                    No Data
                  </span>
                </slot>
              </td>
            </tr>
          </tbody>
      </table>
    </div>
    <div v-if="paginated" class="flex justify-between mt-2.5">
      <caption class="text-sm text-gray-700">
        {{ caption }}
      </caption>
      <div class="flex gap-2">
        <div class="flex items-center gap-x-2">
          <p class="text-sm text-nowrap text-gray-600">
            Per Page:
          </p>
          <PerPageOptions v-model="tableFilters.per_page" />
        </div>
        <Pagination
          v-model:page="tableFilters.page"
          :per-side="paginationConfig?.per_side!"
          :per-page="tableFilters.per_page"
          :total="paginationConfig?.total!"
        />
      </div>
    </div>
  </div>
</template>

<style>
tbody tr td.row-cell {
  @apply px-6 py-4 text-gray-800 whitespace-nowrap dark:text-gray-200
}
</style>