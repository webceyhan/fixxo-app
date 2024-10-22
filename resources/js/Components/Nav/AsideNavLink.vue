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
    :class="{
      // base
      'flex items-center border-l pl-4 -ml-px capitalize space-x-2': true,
      // normal
      'border-transparent hover:border-slate-400 dark:hover:border-slate-500 text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300': !active,
      // active
      'border-current font-semibold text-indigo-500 dark:text-indigo-400': active,
    }"
    :href="$page.url"
    preserve-state
  >
    <slot>
      <Icon v-if="icon" :name="icon" class="text-lg" />
      <span>{{ label }}</span>
    </slot>
  </Link>
</template>
