<script setup lang="ts">
defineProps<{
  label?: any;
  value?: any;
  description?: any;
}>();
</script>

<template>
  <div>
    <p
      v-if="label"
      class="text-xs font-bold opacity-40 tracking-wider uppercase leading-5"
    >
      {{ label }}
    </p>

    <p class="text-base">
      <slot> {{ value }} </slot>
    </p>

    <p v-if="description" class="text-alt">
      {{ description }}
    </p>
  </div>
</template>
