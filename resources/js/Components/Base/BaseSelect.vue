<script setup>
import { ref, onMounted } from "vue";

defineProps({
  modelValue: [String, Number, Boolean],
  options: [Array, Object],
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
  <select
    ref="input"
    class="appearance-none rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm transition ease-in-out duration-300"
    @change="$emit('update:modelValue', $event.target.value)"
    :value="modelValue"
  >
    <slot>
      <option v-for="(value, key) in options" v-bind="{ key, value }">
        {{ value ?? key }}
      </option>
    </slot>
  </select>
</template>
