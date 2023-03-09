<script setup>
import { ref, onMounted } from "vue";

defineProps({
  modelValue: [String, Number, Boolean],
  noRounding: Boolean,
});

defineEmits(["update:modelValue"]);

const input = ref(null);

defineExpose({
  focus: () => input.value.focus(),
});

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});
</script>

<template>
  <input
    ref="input"
    type="text"
    class="appearance-none border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm transition ease-in-out duration-300"
    :class="{
      'rounded-md': !noRounding,
    }"
    @input="$emit('update:modelValue', $event.target.value)"
    :value="modelValue"
  />
</template>
