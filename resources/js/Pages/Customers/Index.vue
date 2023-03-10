<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import CustomerList from "./Partials/CustomerList.vue";
import Card from "@/Components/Card.vue";

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
      <Pagination v-bind="customers" class="flex-shrink-0" />
    </div>

    <Card class="-mx-4 sm:m-0" flush>
      <CustomerList :customers="customers.data" />
    </Card>
  </AuthenticatedLayout>
</template>
