<script setup lang="ts">
import { onBeforeMount, provide, readonly } from 'vue';
import DataSummary from '../components/DataSummary.vue';
import DataChart from '../components/DataChart.vue';
import LatestIssued from '../components/LatestIssued.vue';
import { useDashboard } from '../store/dashboard';
import { dashboardKey } from '@/@types/injection-key/dashboard';
import { storeToRefs } from 'pinia';
import DateRange from '@/components/ui/daterange-picker/DateRange.vue';

const store = useDashboard()
const { dashboard } = storeToRefs(store)

onBeforeMount(
  async () => {
    await store.getData()
  }
)

provide(dashboardKey, dashboard)
</script>

<template>
  <div>
    <h1 class="text-xl font-medium mb-4">
      Dashboard
    </h1>
    <div class="flex flex-col gap-4">
      <div class="flex justify-end">
        <DateRange disabled />
      </div>
      <DataSummary />
      <DataChart />
      <LatestIssued />
    </div>
  </div>
</template>