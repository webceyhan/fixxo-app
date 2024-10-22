<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import TableData from "@/Components/Table/TableData.vue";

const props = defineProps<{
  href?: string;
}>();

const visit = () => {
  props.href && router.visit(props.href);
};
</script>

<template>
  <tr class="hover border-b-0" @click="visit">
    <slot />

    <TableData v-if="href" class="w-8 pl-0 text-end">
      <Icon name="chevron-right" class="text-sm opacity-50" />
    </TableData>
  </tr>
</template>
