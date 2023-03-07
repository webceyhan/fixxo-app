<script setup>
import AssetBadge from "./AssetBadge.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";

const props = defineProps({
  assets: Array,
  compact: Boolean,
});
</script>

<template>
  <StackedList>
    <StackedListItem
      v-for="asset in assets"
      :key="asset.id"
      :icon="asset.type"
      :href="route('assets.show', asset.id)"
    >
      <div class="w-full" :class="{ 'md:w-6/12': !compact }">
        {{ asset.brand }}
        {{ asset.name }}

        <div v-if="asset.customer" class="text-sm text-gray-400 mt-1">
          {{ asset.customer.name }}
        </div>
      </div>

      <div
        v-if="!compact && asset.tasks_count"
        class="hidden md:block w-2/12 text-gray-400"
      >
        tasks {{ asset.tasks_count }}
      </div>

      <div
        v-if="!compact && asset.total_cost"
        class="hidden md:block w-2/12 text-gray-400"
      >
        cost {{ asset.total_cost }}€
      </div>

      <div v-if="!compact" class="w-fit md:w-2/12">
        <AssetBadge :status="asset.status" />
      </div>
    </StackedListItem>
  </StackedList>
</template>
