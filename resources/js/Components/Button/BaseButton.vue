<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import Icon from "../Icon.vue";

const props = defineProps({
  label: String,
  icon: String,
});

const classes = computed(() => ({
  // base styles
  "inline-flex items-center shadow-sm disabled:opacity-50 px-4 py-2 gap-2": true,

  // text
  "text-xs font-semibold tracking-widest uppercase": true,

  // border
  "border rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800": true,

  // effect
  "transition ease-in-out duration-150": true,
}));
</script>

<template>
  <Link v-if="$attrs.href" :class="classes" as="button">
    <slot>
      <Icon v-if="icon" :name="icon" />
      <span v-if="label">{{ label }}</span>
    </slot>
  </Link>

  <button v-else :class="classes" type="button">
    <slot>
      <Icon v-if="icon" :name="icon" />
      <span>{{ label }}</span>
    </slot>
  </button>
</template>
