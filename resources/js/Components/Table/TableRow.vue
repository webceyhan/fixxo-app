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
  <tr
    :class="{ 'hover:bg-gray-200 dark:hover:bg-gray-700/30 cursor-pointer': href }"
    @click="onClick"
  >
    <TableData v-if="$slots.avatar" class="!pr-0 w-0">
      <div class="relative">
        <slot name="avatar" />

        <div class="lg:hidden absolute bottom-0 left-0">
          <slot name="badge" />
        </div>
      </div>
    </TableData>

    <slot />

    <TableData v-if="$slots.action || href" class="!pl-0 w-0">
      <slot name="action">
        <Icon name="chevron-right" class="text-sm opacity-50" />
      </slot>
    </TableData>
  </tr>
</template>
