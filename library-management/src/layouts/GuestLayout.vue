<script setup lang="ts"></script>

<template>
  <section class="w-full h-dvh flex">
    <div class="w-full md:w-1/3 h-full">
      <RouterView />
    </div>
    <section class="hero-container">
      <div class="absolute bottom-12 left-14">
        <h1 class="text-4xl text-gray-100">
          Library Management System
        </h1>
        <p class="max-w-2xl text-gray-300 mt-1.5">
          This demo project was created solely to showcase my coding approach, style,
          and skills to potential employers, including expertise in UI/UX design
          and full-stack development.
        </p>
      </div>
    </section>
  </section>
</template>

<style>
.hero-container {
  @apply w-full h-full hidden md:w-2/3 md:flex md:px-5 bg-blue-700 relative overflow-hidden;
  background: linear-gradient(0deg, #204cb1f3, #170b688e), url('../assets/images/hero_bg.jpg');
  background-repeat: no-repeat;
  background-size: cover;
  background-position: bottom;
}
</style>