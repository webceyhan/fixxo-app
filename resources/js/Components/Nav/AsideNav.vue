<script setup lang="ts">
import AsideNavLink from "./AsideNavLink.vue";

defineProps<{
  label?: string;
  links?: any[]; // TODO: define type
}>();
</script>
<template>
  <div>
    <h5 class="mb-8 lg:mb-3 font-semibold" v-html="label" />

    <div class="space-y-6 lg:space-y-2 border-l border-neutral">
      <slot>
        <AsideNavLink v-for="link in links" v-bind="link" />
      </slot>
    </div>
  </div>
</template>
