<script setup lang="ts">
import Card from "@/Components/Card.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps<{
  meta: any; // TODO define type (same as pagination props)
}>();
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
