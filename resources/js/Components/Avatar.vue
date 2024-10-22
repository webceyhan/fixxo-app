<script setup lang="ts">
import Icon from "@/Components/Icon.vue";

defineProps<{
  src?: string;
  icon?: string;
}>();
</script>

<template>
  <div class="avatar placeholder rounded-full size-12">
    <div class="bg-neutral text-neutral-content size-full rounded-full">
      <slot>
        <img v-if="src" :src="src" />

        <Icon v-if="icon" :name="icon" class="text-2xl" />
      </slot>
    </div>
  </div>
</template>
