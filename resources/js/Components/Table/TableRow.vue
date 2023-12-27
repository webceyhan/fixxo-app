<script setup>
import { router } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import TableData from "@/Components/Table/TableData.vue";

const props = defineProps({
  href: String,
  badgeClass: String,
});

function onClick(e) {
  props.href && router.visit(props.href);
}
</script>

<template>
  <tr :class="['bg-base-300', { hover: href }]" @click="onClick">
    <TableData v-if="$slots.avatar">
      <div class="relative">
        <slot name="avatar" />

        <div class="lg:hidden absolute bottom-0 left-0" :class="badgeClass">
          <slot name="badge" />
        </div>
      </div>
    </TableData>

    <slot />

    <TableData v-if="$slots.action || href" class="text-end">
      <slot name="action">
        <Icon name="chevron-right" class="text-sm opacity-50" />
      </slot>
    </TableData>
  </tr>
</template>
