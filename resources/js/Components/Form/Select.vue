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
    class="select select-bordered w-full"
    @change="$emit('update:modelValue', $event.target.value)"
    :value="modelValue"
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
