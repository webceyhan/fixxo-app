<script setup>
import AsideNavLink from "./AsideNavLink.vue";

const props = defineProps({
  label: String,
  links: Array,
});
</script>
<template>
  <div>
    <h5 class="mb-8 lg:mb-3 font-semibold">
      {{ label }}
    </h5>

    <div class="space-y-6 lg:space-y-2 border-l border-neutral">
      <slot>
        <AsideNavLink v-for="(link, i) in links" :key="i" v-bind="link" />
      </slot>
    </div>
  </div>
</template>
