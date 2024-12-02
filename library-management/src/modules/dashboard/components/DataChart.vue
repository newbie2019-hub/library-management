<script setup lang="ts">
import DateRange from '@/components/ui/daterange-picker/DateRange.vue';
import { chartData } from '../constants';
import Card from '@/components/ui/card/Card.vue';
import { LineChart } from '@/components/ui/chart-line'
import { inject } from 'vue';
import { dashboardKey } from '@/@types/injection-key/dashboard';
import { format } from 'date-fns';

const dashboard = inject(dashboardKey)
</script>

<template>
  <div class="flex flex-wrap md:flex-nowrap items-stretch h-full gap-4">
    <div class="w-full md:w-1/3">
      <Card class="py-5 px-3 h-full">
        <div class="flex justify-between">
          <p class="mb-1.5 ml-3">
            Overdue Books
          </p>
          <p class="mr-3 text-gray-600 dark:text-gray-400 text-sm">
            <span>Total: </span>
            {{ dashboard?.overdue.total_count }}
          </p>
        </div>
        <ul class="flex flex-col mt-2.5 max-h-96 overflow-y-auto">
          <li
            v-for="(overdue, i) in dashboard?.overdue.books"
            :key="overdue.id"
            class="text-sm font-normal px-3 transition-all duration-200 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-800/60 active:bg-gray-200 py-2 rounded-md cursor-pointer"
          >
            <div class="flex gap-2">
              <div>
                <img
                  v-if="overdue.book.cover_photo"
                  :src="overdue.book.cover_photo"
                  :alt="overdue.book.title"
                  class="object-fit"
                  width="100"
                >
                <div class="w-12 h-full bg-gray-100 dark:bg-gray-800 rounded-md" />
              </div>
              <div>
                <p class="truncate text-ellipsis">
                  {{ overdue.book.title }}
                </p>
                <p class="truncate text-ellipsis text-gray-500 dark:text-gray-400">
                  Quantity: {{ overdue.quantity }}
                </p>
                <p class="text-gray-500 dark:text-gray-400">
                  Due: {{ format(overdue.issued_at, 'PPpp') }}
                </p>
              </div>
            </div>
          </li>
        </ul>
      </Card>
    </div>
    <div class="w-full md:w-2/3">
      <Card class="py-5 h-full pr-5 pl-4">
        <div class="flex justify-between">
          <p class="font-medium mb-1.5 ml-3">
            Issued Books Overview
          </p>
        </div>
        <!-- <LineChart
          :data="dashboard?.chartData!"
          index="issued_date"
          :categories="['issued_date']"
        /> -->
      </Card>
    </div>
  </div>
</template>