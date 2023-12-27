<script setup>
import HashTagNavLink from "./HashTagNavLink.vue";

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

    <div class="flex flex-wrap gap-2">
      <slot>
        <HashTagNavLink v-for="(link, i) in links" :key="i" v-bind="link" />
      </slot>
    </div>
  </div>
</template>
