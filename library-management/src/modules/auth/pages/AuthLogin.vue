<script setup lang="ts">
import LoginForm from '../components/forms/LoginForm.vue';

</script>

<template>
  <div class="flex flex-col justify-center h-full">
    <div class="md:px-6 md:max-w-sm mx-auto w-full">
      <div class="mb-4">
        <h1 class="text-lg">Sign in to your account</h1>
        <p class="text-sm text-gray-600">Please enter your credentials to login</p>
      </div>
      <LoginForm />
    </div>
  </div>
</template>