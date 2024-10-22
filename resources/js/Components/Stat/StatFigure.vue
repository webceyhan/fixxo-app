<script setup>
import Icon from "@/Components/Icon.vue";

defineProps({
  icon: String,
});
</script>

<template>
  <div class="stat-figure">
    <slot>
      <Icon :name="icon" />
    </slot>
  </div>
</template>
