<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  label: String,
  active: Boolean,
});
</script>

<template>
  <Link
    :class="{
      // normal
      'text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300': !active,
      // active
      'font-semibold text-indigo-500 dark:text-indigo-400': active,
    }"
    :href="$page.url"
    preserve-state
  >
    <slot>#{{ label }}</slot>
  </Link>
</template>
