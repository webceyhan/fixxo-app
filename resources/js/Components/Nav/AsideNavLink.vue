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
    :class="[
      'link no-underline capitalize flex items-center border-l pl-4 -ml-px space-x-2',
      {
        'border-transparent hover:border-neutral-content/50': !active,
        'border-current text-primary': active,
      },
    ]"
    :href="$page.url"
    preserve-state
  >
    <slot>
      <Icon v-if="icon" :name="icon" class="text-lg" />
      <span class="whitespace-nowrap">{{ label }}</span>
    </slot>
  </Link>
</template>
