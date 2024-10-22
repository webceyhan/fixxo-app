<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";
import OrderTable from "./Partials/OrderTable.vue";

defineProps<{
  orders: any; // TODO: define Order type
  filters: any; // TODO: define Filter type
}>();
</script>

<template>
  <AuthenticatedLayout title="Orders">
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="filters" class="basis-full xl:basis-2/3" />
    </div>

    <PaginationWrapper :meta="orders">
      <OrderTable :orders="orders.data" />
    </PaginationWrapper>
  </AuthenticatedLayout>
</template>
