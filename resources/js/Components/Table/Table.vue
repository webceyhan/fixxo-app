<script setup>
defineProps({
  headerClass: String,
  bodyClass: String,
});
</script>

<template>
  <table class="min-w-full">
    <thead v-if="$slots.header" :class="headerClass">
      <tr>
        <slot name="header" />
      </tr>
    </thead>

    <tbody
      :class="bodyClass"
      class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300"
    >
      <slot />
    </tbody>
  </table>
</template>
