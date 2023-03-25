<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";
import AssetTable from "./Partials/TicketTable.vue";

const props = defineProps({
  tickets: Object,
  filters: Object,
});
</script>

<template>
  <AuthenticatedLayout title="Tickets">
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="filters" class="basis-full xl:basis-2/3" />
    </div>

    <PaginationWrapper :meta="tickets" class="flex-1">
      <AssetTable :tickets="tickets.data" />
    </PaginationWrapper>
  </AuthenticatedLayout>
</template>
