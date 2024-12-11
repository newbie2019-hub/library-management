import * as z from 'zod'
import { toTypedSchema } from '@vee-validate/zod'
import type { TypedSchema } from 'vee-validate'

const categoryValidation = z.object({
  category: z.string().min(1, 'Category is required'),
})

export type Category = z.infer<typeof categoryValidation>

export const CategorySchema: TypedSchema<z.infer<typeof categoryValidation>> =
  toTypedSchema(categoryValidation)
