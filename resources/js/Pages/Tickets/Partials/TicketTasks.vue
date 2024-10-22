<script setup lang="ts">
import { ref } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import TaskList from "./Task/TaskList.vue";
import TaskModal from "./Task/TaskModal.vue";

const props = defineProps<{
  ticket: any; // TODO: define Ticket type
  tasks: any; // TODO: define Task type
  canDelete: boolean;
}>();

// Task Modal
const editing = ref(null);
const modalOpen = ref(false);

const create = () => {
  edit({ ticket_id: props.ticket.id });
};

const edit = (task: any) => {
  editing.value = task;
  modalOpen.value = true;
};

defineExpose({
  create,
  edit,
});
</script>

<template>
  <Card flush>
    <template #header>
      Tasks

      <span class="mr-auto opacity-50">
        {{ ticket.completed_tasks_count }}/{{ ticket.total_tasks_count }}
      </span>

      <SecondaryButton label="New Task" icon="create" @click="create" small />
    </template>

    <TaskList :tasks="tasks" @select="edit" />
    <TaskModal v-model:open="modalOpen" :task="editing" :can-delete="canDelete" />

    <template #footer>
      <span class="w-1/4">Total Cost</span>
      <span class="mr-8">
        {{ formatMoney(ticket.invoice.tasks_cost) }}
      </span>
    </template>
  </Card>
</template>
