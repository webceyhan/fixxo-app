<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import TaskCard from "./Partials/TaskCard.vue";
import TicketCard from "../Tickets/Partials/TicketCard.vue";

const props = defineProps({
  task: Object,
});
</script>

<template>
  <PageLayout :title="task.description" content-only-mobile>
    <template #toolbar>
      <SecondaryButton label="Edit" icon="edit" :href="route('tasks.edit', task.id)" />
      <DangerButton
        label="Delete"
        icon="delete"
        method="delete"
        :href="route('tasks.destroy', task.id)"
      />
    </template>

    <template #aside>
      <TicketCard :ticket="task.ticket" />
    </template>

    <template #content>
      <TaskCard :task="task" />
    </template>
  </PageLayout>
</template>
