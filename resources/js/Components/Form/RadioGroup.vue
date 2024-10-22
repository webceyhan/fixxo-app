<script setup lang="ts">
import { normalizeOptions } from "@/Shared/form";

defineProps<{
  name?: string;
  options?: any[] | object; // TODO: define type
  fancy?: boolean;
}>();

const model = defineModel<string | number>();
</script>

<template>
  <template v-if="fancy">
    <div class="tabs tabs-boxed p-2">
      <a
        v-for="option in normalizeOptions(options)"
        :class="['tab', { 'tab-active': option.value === model }]"
        @click.prevent="model = option.value"
        v-html="option.label"
      />
    </div>
  </template>

  <div v-else class="form-control flex flex-col md:flex-row gap-1 md:gap-5">
    <label v-for="option in normalizeOptions(options)" class="label cursor-pointer gap-2">
      <input class="radio" type="radio" :name :value="option.value" v-model="model" />
      <span class="label-text mr-auto" v-html="option.label" />
    </label>
  </div>
</template>
