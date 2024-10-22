<script>
let index = 0;
</script>

<script setup>
import { normalizeOptions } from "@/Shared/form";

const uuid = `radio-group-${index++}`;

defineProps({
  modelValue: [String, Number, Boolean],
  options: Object,
  fancy: Boolean,
});

defineEmits(["update:modelValue"]);
</script>

<template>
  <div v-if="fancy">
    <div class="tabs tabs-boxed p-2">
      <a
        v-for="(option, i) in normalizeOptions(options)"
        :class="['tab', { 'tab-active': option.value === modelValue }]"
        :value="option.value"
        @click="$emit('update:modelValue', option.value)"
      >
        {{ option.label }}
      </a>
    </div>
  </div>

  <div v-else class="form-control flex flex-col md:flex-row gap-1 md:gap-5">
    <label
      v-for="(option, i) in normalizeOptions(options)"
      class="label cursor-pointer gap-2"
    >
      <input
        type="radio"
        class="radio"
        :name="uuid"
        :value="option.value"
        :checked="option.value === modelValue"
        @change="$emit('update:modelValue', option.value)"
      />
      <span class="label-text mr-auto">{{ option.label }}</span>
    </label>
  </div>
</template>
