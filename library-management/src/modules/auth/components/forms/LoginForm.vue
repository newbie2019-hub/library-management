<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { useAuthStore } from '../../store/auth';
import { useForm } from 'vee-validate';
import { LoginSchema } from '../../schema/auth';

const store = useAuthStore()

const form = useForm({
  validationSchema: LoginSchema,
  initialValues: {
    email: 'hillard.windler@example.org',
    password: 'password'
  }
})

const login = form.handleSubmit(
  async (values, { resetForm, setFieldError }) => {
    await store.login(values, setFieldError)
})
</script>

<template>
  <form @submit="login">
    <FormField v-slot="{ componentField }" name="email">
      <FormItem>
        <FormLabel>Email Address</FormLabel>
        <FormControl>
          <Input type="text" placeholder="john@gmail.com" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="password">
      <FormItem class="mt-2">
        <FormLabel>Password</FormLabel>
        <FormControl>
          <Input class="" type="password" placeholder="******" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ value, handleChange }" type="checkbox" name="remember">
      <FormItem class="flex flex-row items-center gap-x-1.5 space-y-0 mt-3">
        <FormControl>
          <Checkbox :checked="value" @update:checked="handleChange" />
        </FormControl>
        <div class="leading-none">
          <FormLabel class="text-sm">Remember Me</FormLabel>
          <FormMessage />
        </div>
      </FormItem>
    </FormField>
    <Button
      type="submit"
      class="mt-5 w-full flex"
      :loading="store.loading"
      :disabled="store.loading"
    >
      Login
    </Button>
  </form>
</template>