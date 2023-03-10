<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import CustomerList from "./Partials/CustomerList.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";

defineProps({
  customers: Object,
  filters: Object,
});
</script>

<template>
  <AuthenticatedLayout title="Customers">
    <template #actions>
      <PrimaryButton
        label="New"
        icon="create"
        class="!rounded-full"
        :href="route('customers.create')"
      />
    </template>

    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="filters" class="basis-1/2" />
    </div>

    <PaginationWrapper :meta="customers">
      <CustomerList :customers="customers.data" />
    </PaginationWrapper>
  </AuthenticatedLayout>
</template>
