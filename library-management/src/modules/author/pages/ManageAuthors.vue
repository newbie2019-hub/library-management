<script setup lang="ts">
import { onBeforeMount } from 'vue'
import AuthorsTable from '../components/AuthorsTable.vue'
import { useAuthorStore } from '../store/authors'

const { getData } = useAuthorStore()

onBeforeMount(async () => {
  await getData()
})
</script>

<template>
  <div class="flex flex-col gap-4 pb-5">
    <div class="mb">
      <h1 class="text-xl font-medium mb-4">Authors</h1>
      <!-- Add a chart to show category which has more books associated -->
    </div>
    <AuthorsTable />
  </div>
</template>
