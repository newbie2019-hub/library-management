<script setup lang="ts">
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage
} from '@/components/ui/form'
import { useSettingStore } from '../../store/settings';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';

const store = useSettingStore()
</script>

<template>
  <form @submit="store.onSubmitPersonal" class="flex flex-col gap-y-2">
    <FormField v-slot="{ componentField }" name="email">
      <FormItem>
        <FormLabel>Email Address</FormLabel>
        <FormControl>
          <Input type="email" placeholder="john@gmail.com" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="old_password">
      <FormItem>
        <FormLabel>Old Password</FormLabel>
        <FormControl>
          <Input type="password" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="new_password">
      <FormItem>
        <FormLabel>New Password</FormLabel>
        <FormControl>
          <Input type="password" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="confirm_password">
      <FormItem>
        <FormLabel>Confirm Password</FormLabel>
        <FormControl>
          <Input type="password" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <div class="flex justify-end">
      <Button
        type="submit"
        class="mt-5 flex"
        :loading="store.personalInfoLoading"
        :disabled="store.personalInfoLoading"
      >
        Save Changes
      </Button>
    </div>
  </form>
</template>