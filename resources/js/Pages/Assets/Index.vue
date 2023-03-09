<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import AssetList from "./Partials/AssetList.vue";
import Card from "@/Components/Card.vue";
import Link from "@/Components/Link.vue";

const props = defineProps({
  assets: Object,
  filters: Object,
});

const { brand, type, ...restFilters } = props.filters;
</script>

<template>
  <AuthenticatedLayout title="Assets">
    <!-- <template #actions>
      <PrimaryButton label="New" icon="create" :href="route('assets.create')" />
    </template> -->

    <div class="flex flex-col lg:flex-row lg:justify-between px-4 sm:p-0 gap-6">
      <Searchbar :filters="restFilters" class="basis-1/2" />
      <Pagination v-bind="assets" class="flex-shrink-0" />
    </div>

    <div class="flex gap-6">
      <div class="hidden lg:block w-1/6 flex-shrink-0">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
          Filter by type
        </h3>
        <div class="flex flex-wrap gap-x-4 gap-y-2">
          <Link
            v-for="(value, i) in type"
            :key="i"
            :href="$page.url"
            :data="{ type: value }"
            preserve-state
          >
            #{{ value }}
          </Link>
        </div>

        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-10 mb-2">
          Filter by brand
        </h3>
        <div class="flex flex-wrap gap-x-4 gap-y-2">
          <Link
            v-for="(value, i) in brand"
            :key="i"
            :href="$page.url"
            :data="{ brand: value }"
            preserve-state
          >
            #{{ value }}
          </Link>
        </div>
      </div>

      <div class="flex-1">
        <Card flush>
          <AssetList :assets="assets.data" />
        </Card>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
