<script setup lang="ts">
import Link from "@/Components/Link.vue";
import Field from "./Field.vue";

defineProps<{
  href?: string;
  value?: any;
  target?: string;
  native?: boolean;
  email?: boolean;
  phone?: boolean;
  location?: boolean;
}>();
</script>

<template>
  <Field>
    <Link v-if="email" :label="value" :href="`mailto:${value}`" outline native />

    <Link v-else-if="phone" :label="value" :href="`tel:${value}`" outline native />

    <Link
      v-else-if="location"
      :label="value"
      :href="`https://www.google.com/maps/place/${value}`"
      target="_blank"
      outline
      native
    />

    <Link v-else :label="value" :href :target :native outline />
  </Field>
</template>
