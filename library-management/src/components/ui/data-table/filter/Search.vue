<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { Input } from '../../input'

const model = defineModel<string>()
</script>

<template>
  <div class="relative items-center w-full md:w-72">
    <Input
      id="search"
      type="text"
      placeholder="Search"
      class="pl-8 text-sm w-full"
      v-model.lazy="model"
    />
    <span
      class="absolute start-0 inset-y-0 flex items-center justify-center px-2"
    >
      <Icon
        icon="mdi:search"
        class="text-gray-600 shrink-0 ml-1"
      />
    </span>
  </div>
</template>
