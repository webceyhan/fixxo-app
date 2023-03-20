<script setup>
import Icon from "@/Components/Icon.vue";
import UserMenu from "@/Layouts/Partials/UserMenu.vue";

defineEmits(["toggle"]);

const props = defineProps({
  user: Object,
});
</script>

<template>
  <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- left side placeholder -->
        <div class="shrink-0 flex items-center">
          <!-- something comes here later.. -->
        </div>

        <div class="hidden sm:flex sm:items-center sm:ml-6">
          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <UserMenu :user="user" />
          </div>
        </div>

        <!-- Hamburger -->
        <div class="flex items-center sm:hidden">
          <button
            @click="$emit('toggle')"
            class="inline-flex items-center justify-center py-1 px-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
          >
            <Icon name="list" class="text-3xl" />
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>
