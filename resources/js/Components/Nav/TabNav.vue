<script setup lang="ts">
import TabNavItem from "./TabNavItem.vue";

defineProps<{
  links?: any[]; // TODO: define type
  boxed?: boolean;
}>();
</script>

<template>
  <nav role="tablist" :class="['tabs', boxed ? 'tabs-boxed' : 'tabs-bordered']">
    <slot>
      <TabNavItem v-for="link in links" v-bind="link" />
    </slot>

    <div v-if="!boxed" class="w-full border-b-2 border-base-content/20" />
  </nav>
</template>
