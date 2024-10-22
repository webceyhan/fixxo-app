<script setup>
import { router } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import TableData from "@/Components/Table/TableData.vue";

const props = defineProps({
  href: String,
});

function onClick(e) {
  props.href && router.visit(props.href);
}
</script>

<template>
  <tr class="hover border-b-0" @click="onClick">
    <slot />

    <TableData v-if="href" class="w-8 pl-0 text-end">
      <Icon name="chevron-right" class="text-sm opacity-50" />
    </TableData>
  </tr>
</template>
