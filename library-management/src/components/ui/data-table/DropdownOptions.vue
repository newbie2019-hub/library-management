<script setup lang="ts">
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Icon } from '@iconify/vue';
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger>
      <Icon icon="mdi:dots-vertical" />
    </DropdownMenuTrigger>
    <DropdownMenuContent>
      <DropdownMenuItem>Update</DropdownMenuItem>
      <DropdownMenuItem>Delete</DropdownMenuItem>
      <DropdownMenuItem>Restore</DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>