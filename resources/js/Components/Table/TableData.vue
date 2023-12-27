<script setup>
defineProps({
  label: [String, Number],
  value: [String, Number],
  labelClass: String,
  valueClass: String,
});
</script>

<template>
  <td class="whitespace-no-wrap">
    <slot>
      <div class="leading-5" :class="valueClass">
        <slot name="value"> {{ value }} </slot>
      </div>

      <div class="text-sm leading-5 opacity-50" :class="labelClass">
        <slot name="label"> {{ label }} </slot>
      </div>
    </slot>
  </td>
</template>
