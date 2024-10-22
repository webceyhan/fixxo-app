<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    label: String,
    native: Boolean,
    secondary: Boolean,
    outline: Boolean,
    small : Boolean,
});
</script>

<template>
  <component
    :is="native ? 'a' : Link"
    :class="[
      'link link-hover',
      {
        'link-primary': !secondary && !outline,
        'link-secondary': secondary && !outline,
        'border-b border-dashed border-neutral-content/30': outline,
        'text-xm font-medium': small,
      },
    ]"
  >
    <slot> {{ label }} </slot>
  </component>
</template>
