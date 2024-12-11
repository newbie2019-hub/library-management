<script setup lang="ts">
import { CategorySchema, type Category } from '@/@types/schema/categories'
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog'
import DialogContent from '@/components/ui/dialog/DialogContent.vue'
import {
  FormControl,
  FormField,
  FormItem,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { useForm } from 'vee-validate'

const showDialog = defineModel<boolean>()

defineProps<{
  type: 'add' | 'update'
}>()

const form = useForm({
  validationSchema: CategorySchema,
})

const emit = defineEmits<{
  (e: 'confirm-action', category: Category): Promise<void>
}>()

const handleSubmit = form.handleSubmit((values) => {
  emit('confirm-action', values)
})

defineExpose({ form })
</script>

<template>
  <Dialog v-model:open="showDialog">
    <DialogContent class="sm:max-w-[425px]">
      <form @submit.prevent="handleSubmit">
        <DialogHeader>
          <DialogTitle>
            <span class="capitalize">{{ type }}</span>
            Category
          </DialogTitle>
          <DialogDescription>
            Please enter a unique category
          </DialogDescription>
        </DialogHeader>
        <FormField
          v-slot="{ componentField }"
          name="category"
        >
          <FormItem>
            <FormControl>
              <Input
                v-bind="componentField"
                id="category"
                class="mt-3"
                placeholder="Book Category"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <DialogFooter>
          <Button
            class="mt-3"
            variant="secondary"
            @click="showDialog = false"
          >
            Cancel
          </Button>
          <Button
            type="submit"
            class="mt-3"
          >
            {{ type === 'add' ? 'Add Category' : 'Update Category' }}
          </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
