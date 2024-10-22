<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{
  label?: string;
  active?: boolean;
}>();
</script>

<template>
  <Link
    :class="['link link-hover', { 'text-primary': active }]"
    :href="$page.url"
    preserve-state
  >
    <slot> #{{ label }} </slot>
  </Link>
</template>
