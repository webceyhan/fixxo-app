<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";
import InvoiceTable from "./Partials/InvoiceTable.vue";

defineProps<{
  invoices: any; // TODO: define Invoice type
  filters: any; // TODO: define Filter type
}>();
</script>

<template>
  <AuthenticatedLayout title="Invoices">
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="filters" class="basis-full xl:basis-2/3" />
    </div>

    <PaginationWrapper :meta="invoices">
      <InvoiceTable :invoices="invoices.data" />
    </PaginationWrapper>
  </AuthenticatedLayout>
</template>
