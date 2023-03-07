<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Searchbar from "@/Components/Searchbar.vue";
import TaskList from "./Partials/TaskList.vue";
import Card from "@/Components/Card.vue";

defineProps({
  tasks: Object,
  filters: Object,
});
</script>

<template>
  <AuthenticatedLayout title="Tasks">
    <div class="flex justify-between items-center">
      <Searchbar :filters="filters" />
      <Pagination v-bind="tasks" />
    </div>

    <Card flush>
      <TaskList :tasks="tasks.data" />
    </Card>
  </AuthenticatedLayout>
</template>
