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
      'bg-white dark:bg-gray-800/75 overflow-hidden shadow-lg rounded-lg': true,

      // divider
      'divide-y divide-slate-200 dark:divide-slate-700/50': true,

      // flush
      'rounded-none-sm:rounded-lg -mx-4 sm:m-0': flush,
    }"
  >
    <!-- header -->
    <header
      v-if="$slots.header || label"
      class="p-4 sm:p-6"
      :class="{
        'max-sm:bg-white max-sm:dark:bg-gray-900': flush,
      }"
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
