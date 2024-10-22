<script setup>
defineProps({
  title: String,
  subtitle: String,
});
</script>

<template>
  <div class="overflow-hidden bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-xl font-medium leading-6 text-gray-900 dark:text-gray-100">
        <slot name="title">{{ title }}</slot>
      </h3>

      <p v-if="$slots.subtitle" class="mt-1 max-w-2xl text-gray-500">
        <slot name="subtitle">{{ subtitle }}</slot>
      </p>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-900">
      <dl>
        <slot />
      </dl>
    </div>
  </div>
</template>
