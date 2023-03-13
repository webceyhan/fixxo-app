<script setup>
import { useForm } from "@inertiajs/vue3";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const props = defineProps({
  task: Object,
});

// TODO: this must be fetched from the server
const statusOptions = ["pending", "done"];

const form = useForm({
  ...props.task,
  // TODO: see above
  description: props.task.description,
  price: props.task.price ?? 0,
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
      label="Price"
      type="number"
      v-model="form.price"
      :error="form.errors.price"
    />
    <FormControl label="Status" v-model="form.status" :options="statusOptions" />
  </Form>
</template>
