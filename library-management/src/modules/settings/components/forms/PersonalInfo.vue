<script setup lang="ts">
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage
} from '@/components/ui/form'
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { usePersonalInfo } from '../../composables/usePersonalInfo';

const { onSubmitPersonal } = usePersonalInfo();
</script>

<template>
  <form
    id="personal-info"
    @submit="onSubmitPersonal"
    class="flex flex-col gap-y-2"
  >
    <FormField v-slot="{ componentField }" name="first_name">
      <FormItem>
        <FormLabel>First Name</FormLabel>
        <FormControl>
          <Input type="text" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="middle_name">
      <FormItem>
        <FormLabel>Middle Name</FormLabel>
        <FormControl>
          <Input type="text" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="last_name">
      <FormItem>
        <FormLabel>Last Name</FormLabel>
        <FormControl>
          <Input type="text" placeholder="" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="contact_number">
      <FormItem>
        <FormLabel>Contact Number</FormLabel>
        <FormControl>
          <Input type="text" placeholder="" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <FormField v-slot="{ componentField }" name="address">
      <FormItem>
        <FormLabel>Address</FormLabel>
        <FormControl>
          <Input type="text" placeholder="" v-bind="componentField" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>
    <div class="flex justify-end">
      <Button
        type="submit"
        class="mt-5 flex"
      >
        Save Changes
      </Button>
    </div>
  </form>
</template>