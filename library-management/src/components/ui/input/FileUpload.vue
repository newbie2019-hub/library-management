<script setup lang="ts">
import { Input } from '.'
import { Label } from '../label'

defineProps<{
  id: string
  label: string
}>()

const emit = defineEmits<{
  (e: 'update:model-value'): void
}>()
</script>

<template>
  <div class="grid w-full max-w-sm items-center gap-1.5">
    <Label :for="id">
      {{ label }}
    </Label>
    <Input
      :id
      type="file"
    />
  </div>
</template>
