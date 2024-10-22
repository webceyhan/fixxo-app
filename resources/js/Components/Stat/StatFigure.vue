<script setup lang="ts">
import Icon from "@/Components/Icon.vue";

defineProps<{
  icon?: string;
}>();
</script>

<template>
  <div class="stat-figure">
    <slot>
      <Icon :name="icon" />
    </slot>
  </div>
</template>
