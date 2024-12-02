<script setup lang="ts">
import type { TableHeaderEmit } from '@/@types/components/data-table';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Icon } from '@iconify/vue/dist/iconify.js';
import type { HTMLAttributes } from 'vue';

defineProps<{
  label: string
  sort: 'asc' | 'desc' | 'none'
  sortable?: boolean
  class?: HTMLAttributes['class']
}>()

const emit = defineEmits<{
  (e: 'change', data: TableHeaderEmit): void
}>()
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger class="hover:bg-gray-100 dark:hover:bg-gray-800 h-full">
      <div class="flex gap-x-2 uppercase font-normal group" :class="class">
        {{ label }}
        <Icon class="hidden" :class="{'group-hover:block': !sort}" icon="mdi:sort-descending" />
        <Icon v-if="sort === 'asc'" icon="mdi:sort-descending" />
        <Icon v-if="sort === 'desc'" icon="mdi:sort-ascending" />
      </div>
    </DropdownMenuTrigger>
    <DropdownMenuContent>
      <DropdownMenuItem v-if="sortable" @click="emit('change', { type: 'sort', value: 'asc' })" class="cursor-pointer">
        <Icon icon="mdi:sort-descending" />
        Asc
      </DropdownMenuItem>
      <DropdownMenuItem v-if="sortable"  @click="emit('change', { type: 'sort', value: 'desc' })" class="cursor-pointer">
        <Icon icon="mdi:sort-ascending" />
        Desc
      </DropdownMenuItem>
      <DropdownMenuSeparator v-if="sortable" />
      <DropdownMenuItem @click="emit('change', { type: 'visibility_change', value: 'hide' })" class="cursor-pointer">
        <Icon icon="mdi:hide-outline" />
        Hide
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>