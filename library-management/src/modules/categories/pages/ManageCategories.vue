<script setup lang="ts">
import { onBeforeMount } from 'vue'
import CategoriesTable from '../components/CategoriesTable.vue'
import { useCategoryStore } from '../store/categories'

const { getData } = useCategoryStore()

onBeforeMount(async () => {
  await getData()
})
</script>

<template>
  <div class="flex flex-col gap-4 pb-5">
    <div class="mb">
      <h1 class="text-xl font-medium mb-4">Categories</h1>
      <!-- Add a chart to show category which has more books associated -->
    </div>
    <CategoriesTable />
  </div>
</template>
