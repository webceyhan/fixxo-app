<script setup>
import { onMounted, ref } from "vue";
import { normalizeOptions } from "@/Shared/form";

const input = ref(null);

defineEmits(["update:modelValue"]);

defineProps(["modelValue", "options", "type"]);

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
  <select
    ref="input"
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
  >
    <slot>
      <slot name="header" />

      <option
        v-for="(option, i) in normalizeOptions(options)"
        :key="i"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </slot>
  </select>
</template>
