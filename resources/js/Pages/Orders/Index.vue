<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";
import OrderTable from "./Partials/OrderTable.vue";

defineProps({
  orders: Object,
  filters: Object,
});
</script>

<template>
  <AuthenticatedLayout title="Orders">
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="filters" class="basis-full xl:basis-2/3" />
      <!-- <PrimaryButton
        label="New"
        icon="create"
        class="!rounded-full"
        :href="route('orders.create')"
      /> -->
    </div>

    <PaginationWrapper :meta="orders">
      <OrderTable :orders="orders.data" />
    </PaginationWrapper>
  </AuthenticatedLayout>
</template>
