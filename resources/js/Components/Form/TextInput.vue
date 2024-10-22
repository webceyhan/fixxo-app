<script setup>
import { onMounted, ref } from "vue";

defineProps({
  modelValue: [String, Number],
  embedded: Boolean,
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <input
    ref="input"
    type="text"
    :class="[embedded ? 'grow' : 'input input-bordered w-full']"
    @input="$emit('update:modelValue', $event.target.value)"
    :value="modelValue"
  />
</template>
