<script setup>
import TabNavItem from "./TabNavItem.vue";

const props = defineProps({
  links: Array,
  boxed: Boolean,
});
</script>

<template>
  <nav
    role="tablist"
    :class="[
      'tabs',
      {
        'tabs-bordered': !boxed,
        'tabs-boxed': boxed,
      },
    ]"
  >
    <slot>
      <TabNavItem v-for="(link, i) in links" v-bind="link" />
    </slot>
    <div v-if="!boxed" class="w-full border-b-2 border-base-content/20" />
  </nav>
</template>
