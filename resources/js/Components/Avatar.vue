<script setup>
import Icon from "@/Components/Icon.vue";

defineProps({
  icon: String,
});
</script>

<template>
  <div class="flex items-center justify-center">
    <div
      class="bg-gray-200 dark:bg-gray-900 rounded-full w-12 h-12 flex items-center justify-center"
    >
      <slot>
        <Icon :name="icon" class="text-2xl" />
      </slot>
    </div>
  </div>
</template>
