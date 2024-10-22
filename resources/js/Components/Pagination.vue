<script setup>
import Icon from "@/Components/Icon.vue";
import BaseButton from "@/Components/Button/BaseButton.vue";

defineProps(["from", "to", "total", "prev_page_url", "next_page_url"]);
</script>

<template>
  <div class="flex items-center justify-end gap-6">
    <span class="text-base-content/60">
      {{ from }} - {{ to }} of {{ total }} entries
    </span>

    <div class="join">
      <BaseButton
        class="join-item"
        :href="prev_page_url ?? '#'"
        :disabled="!prev_page_url"
      >
        <Icon name="chevron-left" />
        <span class="max-lg:hidden">Previous</span>
      </BaseButton>

      <BaseButton
        class="join-item"
        :href="next_page_url ?? '#'"
        :disabled="!next_page_url"
      >
        <span class="max-lg:hidden">Next Page</span>
        <Icon name="chevron-right" />
      </BaseButton>
    </div>
  </div>
</template>
