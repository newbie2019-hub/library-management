import { toTypedSchema } from '@vee-validate/zod'
import type { TypedSchema } from 'vee-validate'
import * as z from 'zod'

const personalInfo = z.object({
  first_name: z.string().min(1, 'First name is required'),
  middle_name: z.string().nullable(),
  last_name: z.string().min(1, 'Last name is required'),
  contact_number: z.string().nullable(),
  profile_photo: z.string().nullable(),
  address: z.string(),
  type: z.union([z.literal('Librarian'), z.literal('Member')]),
})

const accountInfo = z.object({
  id: z.string(),
  email: z.string(),
  email_verified_at: z.string().nullable(),
  created_at: z.string(),
  updated_at: z.string(),
})

export const PersonalInfoSchema: TypedSchema<z.infer<typeof personalInfo>> =
  toTypedSchema(personalInfo)

export const userSchema = personalInfo.merge(accountInfo)