<script setup>
import Card from "./Card.vue";
import Pagination from "./Pagination.vue";

const props = defineProps({
  meta: Object,
});
</script>

<template>
  <div class="space-y-6 lg:space-y-8">
    <Card flush>
      <slot />

      <div v-if="!meta.total" class="text-center text-xl py-10">
        No results matched your search.
      </div>
    </Card>

    <Pagination v-if="meta.total" v-bind="meta" />
  </div>
</template>
