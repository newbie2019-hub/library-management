import { toTypedSchema } from '@vee-validate/zod'
import type { TypedSchema } from 'vee-validate'
import * as z from 'zod'

const loginForm = z.object({
  email: z.string().email(),
  password: z.string().min(1, 'Password is required'),
  remember: z.boolean().default(false).optional(),
})

const forgotPasswordForm = z.object({
  email: z.string().email()
})

export type UserLogin = z.infer<typeof loginForm>

export const LoginSchema: TypedSchema<z.infer<typeof loginForm>> =
  toTypedSchema(loginForm)

export const ForgotPasswordSchema: TypedSchema<z.infer<typeof forgotPasswordForm>> =
  toTypedSchema(forgotPasswordForm)