<script setup lang="ts">
import { formatDate } from "@/Shared/utils";
import Field from "./Field.vue";

defineProps<{
  value?: any;
  short?: boolean;
}>();
</script>

<template>
  <Field label="Date">
    {{ formatDate(value, !short) }}
    <slot />
  </Field>
</template>
