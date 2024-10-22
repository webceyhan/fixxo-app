<script>
export default {
  inheritAttrs: false,
};
</script>

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
  <li class="mr-2">
    <Link
      role="tab"
      :class="{
        // base
        'inline-block p-4 pb-2 rounded-t-lg border-b-2 capitalize': true,
        // normal
        'border-transparent hover:border-slate-400 dark:hover:border-slate-500 text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300': !active,
        // active
        'font-semibold text-indigo-500 dark:text-indigo-400 border-indigo-600 dark:border-indigo-500': active,
      }"
      :href="$page.url"
      preserve-state
      v-bind="$attrs"
    >
      <slot>
        <Icon v-if="icon" :name="icon" class="text-lg" />
        <span>{{ label }}</span>
      </slot>
    </Link>
  </li>
</template>
