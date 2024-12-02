<script setup lang="ts">
import { useBooks } from '../store/books';
import { headers } from '../constants/table/books';
import { ref, watch } from 'vue';
import debounce from 'lodash.debounce'
import type { CategoryFilterType, IncludedQtyType } from '@/@types/table-filters';
import type { TableFilters } from '@/@types/components/data-table';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import FacetedFilter from '@/components/ui/data-table/filter/FacetedFilter.vue';
import { Badge } from '@/components/ui/badge';
import DropdownOptions from '@/components/ui/data-table/DropdownOptions.vue';

const store = useBooks()

const additionalFilters = ref<{
  category: CategoryFilterType;
  included_quantity: IncludedQtyType;
  page: number
}>({
  category: '',
  included_quantity: '',
  page: 1
})

const fetchData = async (filters?: TableFilters) => {
  await store.getData({ ...additionalFilters.value, ...filters })
}

watch(
  () => additionalFilters.value,
  debounce(async () => {
    await fetchData()
  }, 200),
  { deep: true }
)
</script>

<template>
  <DataTable
    :headers
    :items="store.books?.data"
    striped
    filterClass="justify-between"
    paginated
    hide-row-numbers
    :pagination-config="{
      per_side: 1,
      total: store.books?.total!
    }"
    @filters-change="fetchData"
    :caption="`Showing ${store.books?.from ?? 0} to ${store.books?.to ?? 0} out of ${store.books?.total} books`"
  >
    <template #additional-filters>
      <div class="flex gap-2.5 w-full md:w-fit">
        <FacetedFilter
          v-model="additionalFilters.category"
          btnLabel="Category"
          optionLabel="Filter By"
          :options="[
            { label: 'Categorized', value: 'categorized' },
            { label: 'Uncategorized', value: 'uncategorized' },
          ]"
        />
        <FacetedFilter
          v-model="additionalFilters.category"
          btnLabel="Category"
          optionLabel="Filter By"
          :options="[
            { label: 'Categorized', value: 'categorized' },
            { label: 'Uncategorized', value: 'uncategorized' },
          ]"
        />
        <FacetedFilter
          v-model="additionalFilters.included_quantity"
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
        <Badge variant="secondary">
          +{{ data.categories.length }}
        </Badge>
      </div>
    </template>
    <template #col-options>
      <div class="flex justify-center">
        <DropdownOptions />
      </div>
    </template>
  </DataTable>
</template>