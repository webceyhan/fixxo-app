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
    <div class="flex flex-col lg:flex-row lg:justify-between px-4 sm:p-0 gap-6">
      <div class="flex justify-between items-center gap-4 basis-3/5">
        <Searchbar :filters="filters" />
        <PrimaryButton label="New" icon="create" :href="route('customers.create')" />
      </div>

      <Pagination v-bind="customers" class="flex-shrink-0" />
    </div>

    <Card flush>
      <CustomerList :customers="customers.data" />
    </Card>
  </AuthenticatedLayout>
</template>
