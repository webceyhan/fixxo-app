<script setup>
import { useForm } from "@inertiajs/vue3";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const props = defineProps({
  task: Object,
});

const statusOptions = ["new", "completed", "cancelled"];

const form = useForm({
  ...props.task,
  // TODO: see above
  description: props.task.description,
  cost: props.task.cost ?? 0,
  status: props.task.status ?? statusOptions[0],
});
</script>

<template>
  <Form :form="form" resource="tasks">
    <FormControl
      label="Description"
      rows="3"
      v-model="form.description"
      :error="form.errors.description"
      required
      autofocus
    />

    <FormControl
      label="Cost"
      prefix="€"
      type="number"
      min="0"
      step="1"
      v-model="form.cost"
      :error="form.errors.cost"
    />

    <FormControl label="Status" v-model="form.status" :options="statusOptions" fancy />
  </Form>
</template>
