<script setup lang="ts">
import { useMagicKeys } from '@vueuse/core'

import { ref, watch } from 'vue'
import {
  CommandDialog,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList,
  CommandSeparator
} from '.';
import { Input } from '../input';
import Badge from '../badge/Badge.vue';
import { ROUTE } from '@/@types/routes';

const open = ref(false)

const keys = useMagicKeys()
const CmdJ = keys['Cmd+K']

function handleOpenChange() {
  open.value = !open.value
}

watch(CmdJ, (v) => {
  if (v)
    handleOpenChange()
})

const routeSuggestions = [
  {
    label: 'Dashboard',
    path: { name: ROUTE.DASHBOARD }
  },
  {
    label: 'Books',
    path: { name: ROUTE.MANAGE_BOOKS }
  },
  {
    label: 'Categories',
    path: { name: ROUTE.CATEGORIES }
  },
]
</script>

<template>
  <div>
    <div @click="handleOpenChange" class="flex cursor-text justify-between relative border pl-3 pr-4 w-60 py-1.5 rounded-md">
      <p class="text-sm text-gray-400">
        Search
      </p>
      <div class="">
        <p class="text-sm text-muted-foreground">
          <kbd
            class="pointer-events-none inline-flex h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground opacity-100"
          >
            <span class="text-xs">⌘</span>K
          </kbd>
        </p>
      </div>
    </div>

    <CommandDialog :open="open" @update:open="handleOpenChange">
      <CommandInput placeholder="Type a command or search..." />
      <CommandList>
        <CommandEmpty>No results found.</CommandEmpty>
        <CommandGroup heading="Suggestions">
          <RouterLink
            v-for="route in routeSuggestions"
            :key="route.label"
            :to="route.path"
          >
            <CommandItem @select="open = !open" :value="route.label" class="flex justify-between">
              {{ route.label }}
              <Badge variant="outline" class="font-normal">
                Go To
              </Badge>
            </CommandItem>
          </RouterLink>
        </CommandGroup>
        <CommandSeparator />
      </CommandList>
    </CommandDialog>
  </div>
</template>