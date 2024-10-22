<script setup lang="ts">
import HashTagNavLink from "./HashTagNavLink.vue";

const props = defineProps<{
  label?: string;
  links?: any[]; // TODO: define type
}>();
</script>
<template>
  <div>
    <h5 class="mb-8 lg:mb-3 font-semibold" v-html="label" />

    <div class="flex flex-wrap gap-2">
      <slot>
        <HashTagNavLink v-for="link in links" v-bind="link" />
      </slot>
    </div>
  </div>
</template>
