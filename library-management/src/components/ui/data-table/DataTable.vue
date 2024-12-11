<script setup lang="ts">
import { ref, type HTMLAttributes } from 'vue'
import type {
  PaginationConfig,
  Sort,
  TableHeaderEmit,
  TableHeaders,
  TableItems,
} from '@/@types/components/data-table'
import RowHeader from './filter/RowHeader.vue'
import { computed } from 'vue'
import ColumnFilter from './filter/ColumnFilter.vue'
import Pagination from '../pagination/Pagination.vue'
import Search from './filter/Search.vue'
import PerPageOptions from './PerPageOptions.vue'
import { pagesOption } from '@/constants/pagination'

const props = defineProps<{
  caption?: string
  headers: TableHeaders[]
  items: TableItems | undefined
  striped?: boolean
  filterClass?: HTMLAttributes['class']
  serverSideRequest?: boolean
  paginationConfig?: PaginationConfig
  loading?: boolean
}>()

const model = defineModel<string>('search')
const page = defineModel<number>('page')
const perPage = defineModel<number>('per-page')

type TableCol = TableHeaders & { shown: boolean; sort: Sort }

const columns = ref<TableCol[]>(
  props.headers.map((header) => {
    return { ...header, shown: true, sort: 'none' }
  }),
)

const shownColumns = computed(() => columns.value.filter((col) => col.shown))

const handleHeaderFilter = (data: TableHeaderEmit, col: TableCol) => {
  if (data.type === 'sort') {
    col.sort = data.value
  }
  if (data.type === 'visibility_change') {
    col.shown = false //Hide option from table header
  }
}
</script>

<template>
  <div>
    <div
      class="flex flex-wrap md:flex-nowrap justify-end items-center gap-2 mb-4"
      :class="filterClass"
    >
      <slot name="additional-filters" />
      <div class="flex gap-2 w-full md:w-fit">
        <Search v-model="model" />
        <ColumnFilter
          label=""
          heading="Column Visibility"
          icon="mdi:table-eye"
          v-model="columns"
        />
      </div>
    </div>
    <div class="relative overflow-x-auto">
      <table
        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-300"
      >
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900 dark:text-gray-300"
        >
          <tr>
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
          <div
            v-if="loading"
            class="loader"
          ></div>
        </thead>
        <tbody>
          <tr
            v-if="items?.length === 0"
            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900"
          >
            <td
              :colspan="shownColumns.length"
              class="text-center py-4"
            >
              No Data Found
            </td>
          </tr>
          <tr
            v-if="loading && items?.length === 0"
            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900"
          >
            <td
              :colspan="shownColumns.length"
              class="text-center py-4"
            >
              Loading Data...
            </td>
          </tr>
          <tr
            v-for="(row, i) in items"
            :key="row.id"
            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900"
            :class="[
              {
                'odd:bg-white odd:dark:bg-gray-950 even:bg-gray-50 even:dark:bg-gray-900':
                  striped,
              },
            ]"
          >
            <td
              v-for="(column, j) in shownColumns"
              :key="column.title + j"
              class="row-cell"
              :class="column.rowClass"
            >
              <slot
                :name="`col-${column.key}`"
                :data="row"
                :index="i"
              >
                {{
                  typeof column.value === 'function'
                    ? column.value(row)
                    : row[column?.key]
                }}
                <span
                  v-if="
                    (typeof column.value === 'function'
                      ? column.value(row)
                      : row[column?.key]) === null ||
                    (typeof column.value === 'function'
                      ? column.value(row)
                      : row[column?.key]) === ''
                  "
                  class="text-gray-400"
                >
                  No Data
                </span>
              </slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <span class="text-sm text-gray-700 text-nowrap mt-3 block">
      {{ caption }}
    </span>
    <div
      v-if="serverSideRequest"
      class="flex justify-end mt-2.5"
    >
      <div class="flex relative gap-2">
        <div class="flex items-center gap-x-2">
          <p class="text-sm text-nowrap text-gray-600">Per Page:</p>
          <PerPageOptions
            v-model="perPage"
            :options="pagesOption"
          />
        </div>
        <Pagination
          v-model:page="page"
          :per-side="paginationConfig?.per_side!"
          :per-page="perPage ?? 15"
          :total="paginationConfig?.total!"
        />
      </div>
    </div>
  </div>
</template>

<style>
tbody tr td.row-cell {
  @apply px-6 py-4 text-gray-800 whitespace-nowrap dark:text-gray-200;
}

.loader {
  @apply h-1 w-40 bg-blue-700 rounded-sm absolute animate-loading;
}
</style>
