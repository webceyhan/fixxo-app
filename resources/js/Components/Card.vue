<script setup>
import Icon from "./Icon.vue";

defineProps({
  label: String,
  icon: String,
  flush: Boolean,
});
</script>

<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <!-- header -->
    <header
      v-if="$slots.header || label"
      class="bg-white dark:bg-gray-700 dark:bg-opacity-50 p-4 sm:p-6"
    >
      <slot name="header">
        <Icon v-if="icon" :name="icon" class="mr-2" />
        <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ label }}
        </div>
      </slot>
    </header>

    <!-- body -->
    <div class="text-gray-900 dark:text-gray-100" :class="{ 'p-4 sm:p-6': !flush }">
      <slot />
    </div>

    <footer v-if="$slots.footer" class="flex justify-end p-4 sm:p-6">
      <slot name="footer" />
    </footer>
  </div>
</template>
