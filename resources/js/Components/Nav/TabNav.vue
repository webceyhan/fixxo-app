<script setup>
import TabNavItem from "./TabNavItem.vue";

const props = defineProps({
  links: Array,
});
</script>

<template>
  <nav
    role="tablist"
    class="text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
  >
    <ul class="flex flex-wrap -mb-px">
      <slot>
        <TabNavItem v-for="(link, i) in links" :key="i" v-bind="link" />
      </slot>
    </ul>
  </nav>
</template>
