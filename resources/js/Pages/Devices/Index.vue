<script setup lang="ts">
import { computed } from "vue";
import { createOptionLinks } from "@/Shared/form";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import AsideNav from "@/Components/Nav/AsideNav.vue";
import HashTagNav from "@/Components/Nav/HashTagNav.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";
import DeviceTable from "./Partials/DeviceTable.vue";

const props = defineProps<{
  devices: any; // TODO: define Device type
  filters: any; // TODO: define Filter type
}>();

const { brand, type, ...restFilters } = props.filters;

const typeFilterLinks = computed(() =>
  createOptionLinks("filter[type]", type.options, true)
);

const brandFilterLinks = computed(() =>
  createOptionLinks("filter[brand]", brand.options)
);
</script>

<template>
  <AuthenticatedLayout title="Devices">
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="restFilters" class="basis-full" />
    </div>

    <div class="flex gap-8">
      <div class="hidden lg:block w-1/6 flex-shrink-0 space-y-8">
        <AsideNav label="Filter by type" :links="typeFilterLinks" />

        <HashTagNav label="Filter by brand" :links="brandFilterLinks" />
      </div>

      <PaginationWrapper :meta="devices" class="flex-1">
        <DeviceTable :devices="devices.data" />
      </PaginationWrapper>
    </div>
  </AuthenticatedLayout>
</template>
