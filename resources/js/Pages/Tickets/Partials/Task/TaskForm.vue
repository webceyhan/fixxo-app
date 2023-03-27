<script setup>
import { useForm } from "@inertiajs/vue3";
import { formatDate } from "@/Shared/utils";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const props = defineProps({
  task: Object,
});

const form = useForm({
  ...props.task,
  // TODO: see above
  description: props.task.description,
  price: props.task.price ?? 0,
  is_completed: props.task.is_completed ?? false,
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

    <FormControl label="Completed" type="checkbox" v-model="form.is_completed">
      <span v-if="form.is_completed" class="ml-auto text-sm text-gray-400">
        <em>{{ formatDate(task.completed_at, true) }}</em>
      </span>
    </FormControl>
  </Form>
</template>
