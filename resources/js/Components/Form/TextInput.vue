<script setup lang="ts">
import { onMounted, ref } from "vue";

defineProps<{
  embedded?: boolean;
}>();

const model = defineModel<string | number>();

const input = ref<HTMLInputElement | null>(null);

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
  <input
    ref="input"
    type="text"
    :class="[embedded ? 'grow' : 'input input-bordered w-full']"
    v-model="model"
  />
</template>
