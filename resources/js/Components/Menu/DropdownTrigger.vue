<script setup>
import Icon from "@/Components/Icon.vue";

defineProps({
  label: String,
  icon: String,
  primary: Boolean,
});
</script>

<template>
  <div
    v-if="$slots.default || label"
    tabindex="0"
    role="button"
    :class="['btn', primary ? 'btn-primary' : 'btn-outline']"
  >
    <slot>
      <Icon v-if="icon" :name="icon" />
      {{ label }}
      <Icon name="chevron-down" class="text-sm -me-0.5" />
    </slot>
  </div>

  <div v-else tabindex="0" role="button" class="btn">
    <Icon name="three-dots-vertical" />
  </div>
</template>
