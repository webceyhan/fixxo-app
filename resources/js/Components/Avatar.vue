<script setup>
import Icon from "@/Components/Icon.vue";

defineProps({
  src: String,
  icon: String,
});
</script>

<template>
  <div
    class="flex items-center justify-center w-12 h-12 bg-gray-200 dark:bg-gray-900 rounded-full overflow-hidden"
  >
    <slot>
      <img v-if="src" :src="src" class="object-cover w-full h-full" />
      <Icon v-if="!src" :name="icon" class="text-2xl" />
    </slot>
  </div>
</template>
