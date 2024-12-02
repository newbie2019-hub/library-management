<script lang="ts" setup>
import type { DropdownMenuCheckboxItemProps } from 'radix-vue'
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import type { TableHeaders } from '@/@types/components/data-table';
import { Icon } from '@iconify/vue';

defineProps<{
  label?: string
  heading: string
  icon: string
}>()

const columns = defineModel<(TableHeaders & { shown: boolean })[]>()
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="outline">
        <div class="flex items-center gap-x-2">
          <Icon v-if="icon" :icon="icon" />
          <span class="font-normal">
            {{ label }}
          </span>
        </div>
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent class="w-fit" align="end">
      <DropdownMenuLabel>
        {{ heading }}
      </DropdownMenuLabel>
      <DropdownMenuSeparator />
      <ul>
        <li
          v-for="col in columns"
          :key="col.title"
          class="items-start hover:bg-gray-100 dark:hover:bg-gray-900 pl-2 pr-8 py-1 cursor-pointer"
          @click="() => col.shown = !col.shown"
        >
          <div class="flex gap-x-2 items-center">
            <Icon :icon="col.shown ? 'mdi:show-outline' : 'mdi:hide-outline'" :width="14"/>
            <span class="text-sm">{{ col.title }}</span>
          </div>
        </li>
      </ul>
    </DropdownMenuContent>
  </DropdownMenu>
</template>