<script setup lang="ts">
import type { RowAction } from '@/@types/components/data-table'
import type { TableAction } from '@/@types/table-filters'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Icon } from '@iconify/vue'
import { computed } from 'vue'

const props = defineProps<{
  isDeleted?: Date | null
  options: RowAction
}>()

const emit = defineEmits<{
  (e: 'select', type: TableAction): void
}>()

const filteredOptions = computed(() =>
  props.options.filter((opt) => {
    if (opt.key === 'delete' && props.isDeleted) return false
    if (opt.key === 'restore' && !props.isDeleted) return false
    return true
  }),
)
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger>
      <Icon icon="mdi:dots-vertical" />
    </DropdownMenuTrigger>
    <DropdownMenuContent>
      <DropdownMenuItem
        v-for="opt in filteredOptions"
        :key="opt.key"
        class="cursor-pointer"
        @click="emit('select', opt.key)"
      >
        <Icon
          v-if="opt.icon"
          :icon="opt.icon"
        />
        {{ opt.label }}
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
