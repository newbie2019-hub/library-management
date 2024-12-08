import { toTypedSchema } from '@vee-validate/zod'
import type { TypedSchema } from 'vee-validate'
import * as z from 'zod'

const authorValidation = z.object({
  author: z.string().min(1, 'Name is required'),
})

export type Author = z.infer<typeof authorValidation>

export const AuthorSchema: TypedSchema<z.infer<typeof authorValidation>> =
  toTypedSchema(authorValidation)
