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
  <input type="checkbox" class="checkbox" :value="value" v-model="proxyChecked" />
</template>
