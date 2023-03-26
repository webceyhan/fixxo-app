<script setup>
import { ref } from "vue";
import { formatMoney } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import TaskList from "@/Pages/Tasks/Partials/TaskList.vue";
import TaskModal from "@/Pages/Tasks/Partials/TaskModal.vue";

const props = defineProps({
  ticket: Object,
  tasks: Array,
  canDelete: Boolean,
});

// Task Modal
const modal = ref(null);
const editing = ref(null);

const create = () => {
  edit({ ticket_id: props.ticket.id });
};

const edit = (task) => {
  editing.value = task;
  modal.value.open();
};

defineExpose({
  create,
  edit,
});
</script>

<template>
  <Card label="Tasks" flush>
    <template #header-action>
      <SecondaryButton label="New Task" icon="create" @click="create" small />
    </template>

    <TaskList :tasks="tasks" @select="edit" />
    <TaskModal ref="modal" :task="editing" :can-delete="canDelete" />

    <template #footer>
      <span class="w-full text-right">Total Cost</span>
      <span class="w-2/3 mr-7 sm:mr-9 text-right">
        {{ formatMoney(ticket.cost) }}
      </span>
    </template>
  </Card>
</template>
