<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuRadioGroup,
  DropdownMenuRadioItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import Separator from '../../separator/Separator.vue';
import Badge from '../../badge/Badge.vue';
import { Icon } from '@iconify/vue';

defineProps<{
  btnLabel: string;
  optionLabel: string;
  options: {
    label: string;
    value: string;
  }[]
}>()

const filter = defineModel<string>()

const clearFilters = () => {
  filter.value = ''
}
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger>
      <Button variant="ghost" class="font-normal text-gray-600 dark:text-gray-200 outline-dashed outline-gray-200 dark:outline-gray-700 outline-2">
        <Icon icon="mdi:add-circle-outline" />
        {{ btnLabel }}
        <Separator v-if="filter" orientation="vertical" />
        <Badge v-if="filter" variant="outline" class="font-normal">
          {{ filter }}
        </Badge>
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent class="w-40">
      <DropdownMenuLabel class="font-normal">
        {{ optionLabel }}
      </DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuRadioGroup v-model="filter">
        <DropdownMenuRadioItem
          v-for="opt in options"
          :key="opt.value"
          :value="opt.value"
        >
          {{ opt.label }}
        </DropdownMenuRadioItem>
      </DropdownMenuRadioGroup>
      <DropdownMenuSeparator v-if="filter" />
      <Button
        v-if="filter"
        @click="clearFilters"
        variant="ghost"
        class="block w-full"
      >
        Clear Filter
      </Button>
    </DropdownMenuContent>
  </DropdownMenu>
</template>