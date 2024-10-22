<script setup>
import { computed } from "vue";
import Icon from "@/Components/Icon.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";

const props = defineProps(["from", "to", "total", "prev_page_url", "next_page_url"]);

const hasPrev = computed(() => props.prev_page_url !== null);
const hasNext = computed(() => props.next_page_url !== null);
</script>

<template>
  <div class="flex items-center justify-end gap-4 text-sm font-semibold">
    <span class="text-gray-600 dark:text-gray-500">
      {{ from }} - {{ to }} of {{ total }} entries
    </span>

    <div class="inline-flex">
      <SecondaryButton
        :disabled="!hasPrev"
        :href="prev_page_url ?? '#'"
        class="border-r rounded-r-none"
      >
        <Icon name="chevron-double-left" />
        <span class="hidden lg:inline">Prev</span>
      </SecondaryButton>

      <SecondaryButton
        :disabled="!hasNext"
        :href="next_page_url ?? '#'"
        class="border-l-0 rounded-l-none"
      >
        <span class="hidden lg:inline">Next</span>
        <Icon name="chevron-double-right" />
      </SecondaryButton>
    </div>
  </div>
</template>
