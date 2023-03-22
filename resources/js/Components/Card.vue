<script setup>
import Icon from "./Icon.vue";

defineProps({
  label: String,
  icon: String,
  flush: Boolean,
});
</script>

<template>
  <div
    :class="{
      // base
      'bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg': true,

      // divider
      'divide-y divide-gray-200 dark:divide-gray-900': true,

      // flush
      '-mx-4 sm:m-0': flush,
    }"
  >
    <!-- header -->
    <header
      v-if="$slots.header || label"
      :class="{
        'flex justify-between bg-gray-100/50 dark:bg-gray-700/25 gap-2 p-4 sm:px-6': true,
        'font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight': true,
        'max-sm:bg-gray-200 max-sm:dark:bg-gray-900': flush,
      }"
    >
      <slot name="header">
        <Icon v-if="icon" :name="icon" class="mr-2" />
        <h5>{{ label }}</h5>
      </slot>

      <slot name="header-action" />
    </header>

    <!-- body -->
    <div class="text-gray-900 dark:text-gray-100" :class="{ 'p-4 sm:p-6': !flush }">
      <slot />
    </div>

    <footer v-if="$slots.footer" class="flex justify-end p-4 sm:px-6 text-gray-400">
      <slot name="footer" />
    </footer>
  </div>
</template>
