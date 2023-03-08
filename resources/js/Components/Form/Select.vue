<script setup>
import { onMounted, ref } from "vue";

const input = ref(null);

defineProps(["modelValue", "options", "type"]);

defineEmits(["update:modelValue"]);

defineExpose({ focus: () => input.value.focus() });

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

// Object
// {
//     key: "value",
//    key2: "value2",
//     ..
// }

// Array
// [
//     "value1",
//     "value2",
//     ..
// ]

// this will normalize the key:value pairs as (option, key)
// no matter if the options are passed as an array or an object
const normalizeOptions = (options) => {
  if (Array.isArray(options)) {
    return options.reduce((acc, option) => {
      acc[option] = option;
      return acc;
    }, {});
  }

  return options;
};
</script>

<template>
  <select
    ref="input"
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
  >
    <option v-for="(option, key) in normalizeOptions(options)" :key="key" :value="key">
      {{ option ?? key }}
    </option>
  </select>
</template>
