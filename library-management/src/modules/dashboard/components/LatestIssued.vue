<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { headers } from '../constants/table/dashboard';
import { inject } from 'vue';
import { dashboardKey } from '@/@types/injection-key/dashboard';

const dashboard = inject(dashboardKey)
</script>

<template>
  <div class="pb-5">
    <Card class="py-5 px-5">
      <div class="mb-4 ml-1 leading-5">
        <p class="font-medium">
          Latest Issued
        </p>
        <span class="text-xs text-gray-600 dark:text-gray-400">
          Showing latest issued books
        </span>
      </div>
      <DataTable
        :headers
        :items="dashboard?.latest_issued_books"
        striped
        caption="Showing only the 8 latest issued books"
      />
    </Card>
  </div>
</template>