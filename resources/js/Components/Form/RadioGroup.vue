<script>
let index = 0;
</script>

<script setup>
import { RadioGroup, RadioGroupOption } from "@headlessui/vue";

const id = `radio-group-${index++}`;

defineProps({
  modelValue: [String, Number, Boolean],
  options: Object,
  fancy: Boolean,
});

defineEmits(["change", "update:modelValue"]);
</script>

<template>
  <div v-if="fancy">
    <RadioGroup
      :model-value="modelValue"
      @update:modelValue="$emit('update:modelValue', $event)"
      class="flex text-sm font-semibold dark:text-gray-300 shadow-sm"
    >
      <RadioGroupOption
        v-for="(option, key) in options"
        :key="key"
        :value="key"
        v-slot="{ checked }"
        as="template"
      >
        <div
          :class="{
            'border first:rounded-l-md last:rounded-r-md cursor-pointer py-2 px-4': true,
            'border-gray-300 dark:border-gray-700 dark:bg-gray-900 ': !checked,
            'dark:text-white border-transparent bg-indigo-500 dark:bg-indigo-600': checked,
          }"
        >
          {{ option ?? key }}
        </div>
      </RadioGroupOption>
    </RadioGroup>
  </div>

  <div v-else class="flex flex-col md:flex-row gap-1 md:gap-5">
    <label
      v-for="(option, key) in options"
      :key="key"
      class="inline-flex items-center mt-3 sm:m-0"
    >
      <input
        type="radio"
        :name="id"
        :value="key"
        :checked="key === modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        class="form-radio h-5 w-5 text-gray-600"
      />
      <span class="ml-2 text-gray-500">
        {{ option ?? key }}
      </span>
    </label>
  </div>
</template>
