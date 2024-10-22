<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  label: String,
  active: Boolean,
});
</script>

<template>
  <Link
    :class="['link link-hover', { 'text-primary': active }]"
    :href="$page.url"
    preserve-state
  >
    <slot>#{{ label }}</slot>
  </Link>
</template>
