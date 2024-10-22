<script setup>
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

defineProps({
  label: String,
  icon: String,
  active: Boolean,
});
</script>

<template>
  <Link
    role="tab"
    :class="['tab', { 'tab-active ': active }]"
    :href="$page.url"
    preserve-state
  >
    <slot>
      <Icon v-if="icon" :name="icon" class="text-lg" />
      <span class="whitespace-nowrap">{{ label }}</span>
    </slot>
  </Link>
</template>
