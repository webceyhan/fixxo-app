<script setup>
import { computed } from "vue";
import { createOptionLinks } from "@/Shared/routing";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import AssetList from "./Partials/AssetList.vue";
import Card from "@/Components/Card.vue";
import AsideNav from "@/Components/Nav/AsideNav.vue";
import HashTagNav from "@/Components/Nav/HashTagNav.vue";

const props = defineProps({
  assets: Object,
  filters: Object,
});

const { brand, type, ...restFilters } = props.filters;

const typeFilterLinks = computed(() => createOptionLinks("type", type, true));

const brandFilterLinks = computed(() => createOptionLinks("brand", brand));
</script>

<template>
  <AuthenticatedLayout title="Assets">
    <!-- <template #actions>
      <PrimaryButton label="New" icon="create" class="!rounded-full" :href="route('assets.create')" />
    </template> -->

    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="restFilters" class="basis-1/2" />
      <Pagination v-bind="assets" class="flex-shrink-0" />
    </div>

    <div class="flex gap-6">
      <div class="hidden lg:block w-1/6 flex-shrink-0 space-y-6">
        <AsideNav label="Filter by type" :links="typeFilterLinks" />

        <HashTagNav label="Filter by brand" :links="brandFilterLinks" />
      </div>

      <div class="flex-1">
        <Card class="-mx-4 sm:m-0" flush>
          <AssetList :assets="assets.data" />
        </Card>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
