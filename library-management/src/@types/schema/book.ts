import { toTypedSchema } from '@vee-validate/zod'
import type { TypedSchema } from 'vee-validate'
import * as z from 'zod'

const bookValidation = z.object({
  author_id: z.string().min(1, 'Author is required'),
  isbn_no: z.string().min(13, 'ISBN No is incorrect'),
  title: z.string().min(2, 'Book title is required'),
  quantity: z.number().min(0, 'Invalid books quantity'),
  categories: z.string().array(),
  edition: z.string().optional().nullable(),
  price: z.string().optional().nullable(),
  pages: z.number().optional().nullable(),
  publisher: z.string().optional().nullable(),
  series: z.string().optional().nullable(),
  image: z.instanceof(File)
    .refine((file) => file?.size! < 2 * 1024 * 1024, 'File size must be less than 2MB')
    .optional()
    .nullable(),
  cover_photo: z.string().optional().nullable(),
  published_at: z.string().nullable(),
  purchased_at: z.string().nullable()
})

export type Book = z.infer<typeof bookValidation>

export const BookSchema: TypedSchema<z.infer<typeof bookValidation>> =
  toTypedSchema(bookValidation)
