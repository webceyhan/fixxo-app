<script setup>
import Icon from "@/Components/Icon.vue";

defineProps({
  src: String,
  icon: String,
});
</script>

<template>
  <div class="avatar placeholder rounded-full size-12">
    <div class="bg-neutral text-neutral-content size-full rounded-full">
      <slot>
        <img v-if="src" :src="src" />
        <Icon v-if="!src" :name="icon" class="text-2xl" />
      </slot>
    </div>
  </div>
</template>
