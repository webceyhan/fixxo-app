<script setup lang="ts">
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

const props = defineProps<{
  href?: string;
  label?: string;
  icon?: string;
  small?: boolean;
}>();

const classes = computed(() => [
  "btn uppercase",
  {
    "btn-sm": props.small,
  },
]);
</script>

<template>
  <Link v-if="href" :href :class="classes" as="button">
    <Icon v-if="icon" :name="icon" />
    <slot>
      {{ label }}
    </slot>
  </Link>

  <button v-else :class="classes" type="button">
    <Icon v-if="icon" :name="icon" />
    <slot>
      {{ label }}
    </slot>
  </button>
</template>
