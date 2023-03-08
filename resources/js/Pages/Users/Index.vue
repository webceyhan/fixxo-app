<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import UserList from "./Partials/UserList.vue";
import Card from "@/Components/Card.vue";

defineProps({
  users: Object,
  filters: Object,
});
</script>

<template>
  <AuthenticatedLayout title="Users">
    <div class="flex flex-col lg:flex-row lg:justify-between px-4 sm:p-0 gap-6">
      <div class="flex justify-between items-center gap-4 basis-3/5">
        <Searchbar :filters="filters" />
        <PrimaryButton label="New" icon="create" :href="route('users.create')" />
      </div>

      <Pagination v-bind="users" class="flex-shrink-0" />
    </div>

    <Card flush>
      <UserList :users="users.data" />
    </Card>
  </AuthenticatedLayout>
</template>
