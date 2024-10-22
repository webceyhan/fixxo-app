<script setup lang="ts">
import { onMounted, ref } from "vue";

const model = defineModel<string>();

const input = ref<HTMLTextAreaElement | null>(null);

defineExpose({
  focus: () => input.value?.focus(),
});

onMounted(() => {
  if (input.value?.hasAttribute("autofocus")) {
    input.value?.focus();
  }
});
</script>

<template>
  <textarea ref="input" class="textarea textarea-bordered w-full" v-model="model" />
</template>
