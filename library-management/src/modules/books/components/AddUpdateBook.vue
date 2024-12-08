<script setup lang="ts">
import { ref } from 'vue'
import { BookSchema, type Book } from '@/@types/schema/book'
import Button from '@/components/ui/button/Button.vue'
import DatePicker from '@/components/ui/date-picker/DatePicker.vue'
import { FormField, FormMessage } from '@/components/ui/form'
import FormControl from '@/components/ui/form/FormControl.vue'
import FormItem from '@/components/ui/form/FormItem.vue'
import FormLabel from '@/components/ui/form/FormLabel.vue'
import { Input } from '@/components/ui/input'
import FileUpload from '@/components/ui/input/FileUpload.vue'
import MultiSelect from '@/components/ui/multi-select/MultiSelect.vue'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import {
  Sheet,
  SheetContent,
  SheetDescription,
  SheetHeader,
  SheetTitle,
} from '@/components/ui/sheet'
import { useForm } from 'vee-validate'
import { useAuthorStore } from '@/modules/author/store/authors'

const store = useAuthorStore()
const model = defineModel<boolean>()

const formRef = ref<HTMLFormElement | null>(null)

defineProps<{
  loading: boolean
  type: 'add' | 'update'
}>()

const emit = defineEmits<{
  (e: 'confirm-action', book: Book): void
}>()

const form = useForm({
  validationSchema: BookSchema,
})

const handleSubmit = form.handleSubmit((values) => {
  emit('confirm-action', values)
})

const uploadedImage = ref<string>('')

const generatePreview = () => {
  console.log('Form: ', form.values.image)
  // uploadedImage.value = URL.createObjectURL(form.values.image?[0])
}

defineExpose({ form })
</script>

<template>
  <Sheet
    v-model:open="model"
    class="isolate"
  >
    <SheetContent>
      <SheetHeader class="mb-5 gap-y-0">
        <SheetTitle class="text-start">
          {{ type === 'add' ? 'Add' : 'Update' }} Book
        </SheetTitle>
        <SheetDescription class="text-start">
          Please make sure to enter the correct details for the book.
        </SheetDescription>
      </SheetHeader>
      <div class="overflow-y-auto h-[84%] px-0.5">
        <form
          ref="formRef"
          @submit.prevent="handleSubmit"
          class="text-start flex flex-col gap-1"
        >
          <img
            v-if="uploadedImage"
            :src="uploadedImage ?? form.values.cover_photo"
            alt="profile_image"
            class="w-full object-fit mx-auto"
          />
          <FormField
            v-slot="{ componentField }"
            name="image"
          >
            <FormItem>
              <FormControl>
                <FileUpload
                  id="upload_cover_photo"
                  v-bind="componentField"
                  label="Cover Photo"
                  @update:model-value="generatePreview"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="title"
          >
            <FormItem>
              <FormLabel>Book Title</FormLabel>
              <FormControl>
                <Input
                  type="text"
                  v-bind="componentField"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="categories"
          >
            <FormItem>
              <FormLabel>Categories</FormLabel>
              <FormControl>
                <MultiSelect :options="[{ label: 'Sample 1', value: '1' }]" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="author_id"
          >
            <FormItem>
              <FormLabel>Author</FormLabel>
              <Select v-bind="componentField">
                <FormControl>
                  <SelectTrigger>
                    <SelectValue placeholder="Please select an author" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem
                        v-for="author in store.allAuthors"
                        :key="author.id"
                        :value="author.id"
                      >
                        {{ author.author }}
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </FormControl>
                <FormMessage />
              </Select>
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="isbn_no"
          >
            <FormItem class="mt-2">
              <FormLabel>ISBN No.</FormLabel>
              <FormControl>
                <Input
                  type="text"
                  v-bind="componentField"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <div class="flex gap-x-2">
            <FormField
              v-slot="{ componentField }"
              name="quantity"
            >
              <FormItem>
                <FormLabel>Quantity</FormLabel>
                <FormControl>
                  <Input
                    type="number"
                    v-bind="componentField"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
            <FormField
              v-slot="{ componentField }"
              name="price"
            >
              <FormItem>
                <FormLabel>Price</FormLabel>
                <FormControl>
                  <Input
                    type="number"
                    v-model.number="componentField.modelValue"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>
          <FormField
            v-slot="{ componentField }"
            name="edition"
          >
            <FormItem>
              <FormLabel>Edition</FormLabel>
              <FormControl>
                <Input
                  type="text"
                  v-bind="componentField"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="series"
          >
            <FormItem>
              <FormLabel>Series</FormLabel>
              <FormControl>
                <Input
                  type="text"
                  v-bind="componentField"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <div class="flex gap-x-2">
            <FormField
              v-slot="{ componentField }"
              name="publisher"
            >
              <FormItem>
                <FormLabel>Publisher</FormLabel>
                <FormControl>
                  <Input
                    type="text"
                    v-bind="componentField"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
            <FormField
              v-slot="{ componentField }"
              name="pages"
            >
              <FormItem>
                <FormLabel>Pages</FormLabel>
                <FormControl>
                  <Input
                    type="number"
                    v-bind="componentField"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>
          <FormField
            v-slot="{ componentField }"
            name="published_at"
          >
            <FormItem>
              <FormLabel>Published Date</FormLabel>
              <FormControl>
                <DatePicker
                  v-bind="componentField"
                  @update:model-value="
                    (date) => form.setFieldValue('published_at', date ?? '')
                  "
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="purchased_at"
          >
            <FormItem>
              <FormLabel>Purchased Date</FormLabel>
              <FormControl>
                <DatePicker
                  v-bind="componentField"
                  @update:model-value="
                    (date) => {
                      form.setFieldValue('published_at', date ?? '')
                      console.log('Value: ', date)
                    }
                  "
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </form>
      </div>
      <div class="flex gap-x-2">
        <Button
          variant="outline"
          class="mt-5 w-full flex"
          >Cancel</Button
        >
        <Button
          class="mt-5 w-full flex"
          :loading
          :disabled="loading"
          @click.prevent="() => formRef?.requestSubmit()"
        >
          {{ type === 'add' ? 'Save Book' : 'Save Changes' }}
        </Button>
      </div>
    </SheetContent>
  </Sheet>
</template>
