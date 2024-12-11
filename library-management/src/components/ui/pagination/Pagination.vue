<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Pagination,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from '@/components/ui/pagination'

defineProps<{
  perSide: number
  total?: number
  perPage: number
}>()

const model = defineModel<number>('page')
</script>

<template>
  <Pagination
    v-model:page="model"
    v-slot="{ page }"
    :total="total"
    :sibling-count="perSide"
    show-edges
    :items-per-page="perPage"
    :default-page="1"
  >
    <PaginationList
      v-slot="{ items }"
      class="flex gap-0.5"
    >
      <PaginationFirst />
      <PaginationPrev />

      <template v-for="(item, index) in items">
        <PaginationListItem
          v-if="item.type === 'page'"
          :key="index"
          :value="item.value"
          as-child
        >
          <Button
            class="w-9 h-9 p-0"
            :variant="item.value === page ? 'default' : 'outline'"
          >
            {{ item.value }}
          </Button>
        </PaginationListItem>
      </template>

      <PaginationNext />
      <PaginationLast />
    </PaginationList>
  </Pagination>
</template>
