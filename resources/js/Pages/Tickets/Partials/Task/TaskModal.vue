<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import TaskForm from "./TaskForm.vue";

defineProps<{
  task: any; // TODO: define Task type
  canDelete: boolean;
}>();
</script>

<template>
  <Modal size="xl">
    <template #title>
      <span v-if="task?.id"> Edit Task #{{ task.id }} </span>
      <span v-else> Create Task </span>
    </template>

    <template #default="{ close }">
      <TaskForm
        v-if="task"
        :key="task.id"
        :task="task"
        :deletable="canDelete"
        @dismiss="close"
        dismissable
      />
    </template>
  </Modal>
</template>
