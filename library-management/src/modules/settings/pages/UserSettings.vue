<script setup lang="ts">
import AccountInfo from '../components/forms/AccountInfo.vue'
import PersonalInfo from '../components/forms/PersonalInfo.vue'
import ProfilePhoto from '../components/forms/ProfilePhoto.vue'
</script>

<template>
  <div class="">
    <div>
      <h1 class="text-xl font-medium">Account Setting</h1>
      <p class="text-sm text-gray-600 dark:text-gray-400">
        Update your account information and log-in details
      </p>
    </div>
    <div class="flex flex-wrap md:flex-nowrap mt-14">
      <div class="flex flex-1 flex-col">
        <h1 class="text-lg font-medium">Profile Photo</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">
          Upload a photo of yourself
        </p>
      </div>
      <div class="w-full md:w-1/2">
        <ProfilePhoto />
      </div>
    </div>
    <div class="flex flex-wrap md:flex-nowrap mt-14">
      <div class="flex flex-1 flex-col">
        <h1 class="text-lg font-medium">Personal Info</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">
          Please make sure that your informations are correct
        </p>
      </div>
      <div class="w-full md:w-1/2">
        <PersonalInfo />
      </div>
    </div>
    <div class="flex flex-wrap md:flex-nowrap mt-14">
      <div class="flex flex-1 flex-col">
        <h1 class="text-lg font-medium">Account Info</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 max-w-sm">
          To ensure the security of your account, we recommend to change it
          every 3 months
        </p>
      </div>
      <div class="w-full md:w-1/2">
        <AccountInfo />
      </div>
    </div>
  </div>
</template>
