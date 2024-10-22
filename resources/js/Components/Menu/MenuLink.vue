<script setup>
import { Link } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

defineOptions({
  inheritAttrs: false,
});

defineProps({
  label: String,
  icon: String,
  active: Boolean,
});
</script>

<template>
  <li>
    <component
      :is="$attrs.href ? Link : 'button'"
      :class="{ active }"
      v-bind="$attrs"
      as="button"
    >
      <Icon v-if="icon" :name="icon" />
      <slot>
        {{ label }}
      </slot>
    </component>
  </li>
</template>
