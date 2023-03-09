<script setup>
import { computed } from "vue";
import SecondaryButton from "./SecondaryButton.vue";

const props = defineProps({
  name: String,
  value: [String, Number],
  options: Object, // {value: label}
  icons: Object, // {value: icon}
});

const next = computed(() => {
  const values = Object.keys(props.options);
  const index = values.indexOf(props.value);

  // find next value in options or return first value
  return values[index + 1] ?? values[0];
});
</script>

<template>
  <SecondaryButton :label="options[next]" :icon="icons[next]" :data="{ [name]: next }" />
</template>
