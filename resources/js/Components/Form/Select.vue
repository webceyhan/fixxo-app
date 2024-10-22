<script setup lang="ts">
import { onMounted, ref } from "vue";
import { normalizeOptions } from "@/Shared/form";

defineProps<{
  options?: any[] | object; // TODO: define type
}>();

const model = defineModel<string | number>();

const input = ref<HTMLSelectElement | null>(null);

defineExpose({
  focus: () => input.value?.focus(),
});

onMounted(() => {
  if (input.value?.hasAttribute("autofocus")) {
    input.value?.focus();
  }
});
</script>

<template>
  <select ref="input" class="select select-bordered w-full" v-model="model">
    <slot>
      <slot name="header" />

      <option
        v-for="option in normalizeOptions(options)"
        :value="option.value"
        v-html="option.label"
      />
    </slot>
  </select>
</template>
