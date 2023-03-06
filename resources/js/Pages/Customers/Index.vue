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

const breadcrumbs = [{ label: "Customers" }];
</script>

<template>
  <AuthenticatedLayout title="Customers" :breadcrumbs="breadcrumbs">
    <div class="flex justify-between items-center">
      <Searchbar :filters="filters" />
      <PrimaryButton label="New" :href="route('customers.create')" class="ml-5 mr-auto" />
      <Pagination v-bind="customers" />
    </div>

    <Card flush>
      <CustomerList :customers="customers.data" />
    </Card>
  </AuthenticatedLayout>
</template>
