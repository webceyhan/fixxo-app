<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

defineProps<{
  label?: string;
  icon?: string;
  active?: boolean;
}>();
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

      <span class="whitespace-nowrap" v-html="label" />
    </slot>
  </Link>
</template>
