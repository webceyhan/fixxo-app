<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

const props = defineProps({
  label: String,
  icon: String,
  small: Boolean,
});

const classes = computed(() => [
  "btn uppercase",
  {
    "btn-sm": props.small,
  },
]);
</script>

<template>
  <Link v-if="$attrs.href" :class="classes" as="button">
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
