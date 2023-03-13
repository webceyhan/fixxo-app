<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/Searchbar.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import UserList from "./Partials/UserList.vue";
import PaginationWrapper from "@/Components/PaginationWrapper.vue";

defineProps({
  users: Object,
  filters: Object,
});
</script>

<template>
  <AuthenticatedLayout title="Users">
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">
      <Searchbar :filters="filters" class="basis-1/2" />
      <PrimaryButton
        label="New"
        icon="create"
        class="!rounded-full"
        :href="route('users.create')"
      />
    </div>

    <PaginationWrapper :meta="users">
      <UserList :users="users.data" />
    </PaginationWrapper>
  </AuthenticatedLayout>
</template>
