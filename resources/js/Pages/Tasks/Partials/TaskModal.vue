<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import TaskForm from "./TaskForm.vue";

defineProps({
  task: Object,
  canDelete: Boolean,
});

const modal = ref(null);

defineExpose({
  open: () => modal.value.open(),
  close: () => modal.value.close(),
});
</script>

<template>
  <Modal ref="modal" size="xl">
    <template #title>
      <span v-if="task?.id"> Edit Task #{{ task.id }} </span>
      <span v-else> Create Task </span>
    </template>

    <template #default="{ close }">
      <TaskForm :task="task" @dismiss="close" dismissable :deletable="canDelete" />
    </template>
  </Modal>
</template>
