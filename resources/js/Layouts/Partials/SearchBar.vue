<script setup>
import Icon from "@/Components/Icon.vue";
</script>

<template>
  <div class="relative w-full max-w-lg">
    <span class="absolute inset-y-0 left-0 flex items-center pl-4">
      <Icon class="text-xl text-gray-500" name="search" />
    </span>

    <input
      type="text"
      class="w-full pl-12 py-3 form-input dark:text-white bg-gray-100 dark:bg-gray-900 border-0 focus:ring-indigo-400 dark:focus:ring-indigo-700 rounded-md shadow-sm"
      placeholder="Search"
    />
  </div>
</template>
