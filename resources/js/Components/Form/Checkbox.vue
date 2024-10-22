<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
  value: {
    default: null,
  },
  modelValue: {
    type: [Array, Boolean],
    default: false,
  },
});

const proxyChecked = computed({
  get() {
    return props.modelValue;
  },

  set(val) {
    emit("update:modelValue", val);
  },
});
</script>

<template>
  <input
    type="checkbox"
    :value="value"
    v-model="proxyChecked"
    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
  />
</template>
