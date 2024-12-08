<script setup lang="ts">
import { computed, ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Calendar } from '@/components/ui/calendar'
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import { cn } from '@/lib/utils'
import {
  CalendarDate,
  DateFormatter,
  type DateValue,
  getLocalTimeZone,
  parseDate,
  today,
} from '@internationalized/date'
import { CalendarIcon } from '@radix-icons/vue'

const df = new DateFormatter('en-US', {
  dateStyle: 'long',
})

const placeholder = ref<DateValue>()
const model = defineModel<string>()

const emit = defineEmits<{
  (e: 'update:modelValue', date: string | undefined): void
}>()

const modelValue = computed({
  get: () => (model.value ? parseDate(model.value) : undefined),
  set: (val) => val,
})
</script>

<template>
  <Popover>
    <PopoverTrigger as-child>
      <Button
        variant="outline"
        :class="
          cn(
            'justify-start text-left font-normal w-full',
            !modelValue && 'text-muted-foreground',
          )
        "
      >
        <CalendarIcon class="mr-2 h-4 w-4" />
        {{
          modelValue
            ? df.format(modelValue.toDate(getLocalTimeZone()))
            : 'Pick a date'
        }}
      </Button>
    </PopoverTrigger>
    <PopoverContent class="w-auto p-0">
      <Calendar
        v-model:placeholder="placeholder"
        v-model="modelValue"
        :min-value="new CalendarDate(2000, 1, 1)"
        :max-value="today(getLocalTimeZone())"
        initial-focus
        @update:model-value="(v) => emit('update:modelValue', v?.toString())"
      />
    </PopoverContent>
  </Popover>
</template>
