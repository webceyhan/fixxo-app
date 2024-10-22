<script setup>
defineProps({
  label: [String, Number],
  value: [String, Number],
  labelClass: String,
  valueClass: String,
});
</script>

<template>
  <td
    class="p-4 sm:px-6 whitespace-no-wrap border-b border-gray-200 dark:border-gray-900"
  >
    <slot>
      <div class="leading-5" :class="valueClass">
        <slot name="value"> {{ value }} </slot>
      </div>

      <div class="text-sm leading-5 text-gray-500" :class="labelClass">
        <slot name="label"> {{ label }} </slot>
      </div>
    </slot>
  </td>
</template>
