<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";
import TicketTable from "./Partials/TicketTable.vue";

defineProps<{
  tickets: any; // TODO: define Ticket type
  filters: any; // TODO: define Filter type
}>();
</script>

<template>
  <AuthenticatedLayout title="Tickets">
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="filters" class="basis-full xl:basis-2/3" />
    </div>

    <PaginationWrapper :meta="tickets" class="flex-1">
      <TicketTable :tickets="tickets.data" />
    </PaginationWrapper>
  </AuthenticatedLayout>
</template>
