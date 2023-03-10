<script setup>
import { onMounted, ref, computed } from "vue";

const input = ref(null);

defineEmits(["update:modelValue"]);

const props = defineProps(["modelValue", "options", "type"]);

// Object
// {  key: "value",  key2: "value2" }

// Array
// [  "value1", "value2", ]

// this will normalize the key:value pairs as (option, key)
// no matter if the options are passed as an array or an object
const normalizedOptions = computed(() => {
  return Array.isArray(props.options)
    ? // convert array to object literal as {key: value} pair
      props.options.reduce((acc, opt) => ({ ...acc, [opt]: opt }), {})
    : props.options;
});

defineExpose({ focus: () => input.value.focus() });

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
      <option v-for="(value, key) in normalizedOptions" :key="key" :value="key">
        {{ value ?? key }}
      </option>
    </slot>
  </select>
</template>
