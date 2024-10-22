<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

defineOptions({
  inheritAttrs: false,
});

defineProps<{
  href?: string;
}>();
</script>

<template>
  <li class="text-base hover:translate-x-1 hover:-ms-0.5 transition-all">
    <component
      class="flex justify-between items-center gap-4 sm:gap-6 p-6 sm:px-8 rounded-none"
      :is="href ? Link : 'div'"
      v-bind="{ ...$attrs, href }"
    >
      <!-- default -->
      <slot />

      <Icon name="chevron-right" class="text-xs sm:text-sm opacity-50" />
    </component>
  </li>
</template>
