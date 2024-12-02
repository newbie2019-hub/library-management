import type { User } from "@/@types/api/user"
import { PersonalInfoSchema } from "@/@types/schema/user-details"
import { useForm } from "vee-validate"

export function usePersonalInfo() {
  const form = useForm({
    validationSchema: PersonalInfoSchema
  })

  const onSubmitPersonal = form.handleSubmit((values) => {
    console.log('Values: ', values)
  })

  const setFormValues = (user: User) => {
    console.log('User: ', user)
    form.setValues({
      first_name: 'John Michael'
    })
    console.log('Form: ', form.values)
  }

  return {
    onSubmitPersonal,
    setFormValues
  }
}