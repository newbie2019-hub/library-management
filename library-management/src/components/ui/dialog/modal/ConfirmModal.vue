<script setup lang="ts">
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '..'
import { Button, type ButtonVariants } from '../../button'

const model = defineModel<boolean>()

withDefaults(
  defineProps<{
    title: string
    description: string
    confirmText: string
    cancelText?: string
    confirmVariant: ButtonVariants['variant']
    loading?: boolean
  }>(),
  {
    cancelText: 'Cancel',
  },
)

const emit = defineEmits<{
  (e: 'confirm'): void
}>()
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>
          {{ title }}
        </DialogTitle>
        <DialogDescription>
          {{ description }}
        </DialogDescription>
      </DialogHeader>
      <slot name="body" />
      <DialogFooter>
        <slot name="footer">
          <Button
            @click="model = !model"
            variant="outline"
            :disabled="loading"
          >
            {{ cancelText }}
          </Button>
          <Button
            @click.prevent="emit('confirm')"
            :variant="confirmVariant"
            :loading
            :disabled="loading"
          >
            {{ confirmText }}
          </Button>
        </slot>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
