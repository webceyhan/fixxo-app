<script setup>
import { useForm } from "@inertiajs/vue3";
import { mysqlToDatetimeLocal } from "@/Shared/utils";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const props = defineProps({
  task: Object,
});

// TODO: this must be fetched from the server
const typeOptions = [
  "repair",
  "maintenance",
  "installation",
  "inspection",
  "upgrade",
  "other",
];

const statusOptions = ["new", "completed", "cancelled"];

const form = useForm({
  ...props.task,
  // TODO: see above
  description: props.task.description,
  cost: props.task.cost ?? 0,
  type: props.task.type ?? typeOptions[0],
  status: props.task.status ?? statusOptions[0],
  approved_at: mysqlToDatetimeLocal(props.task.approved_at),
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

    <div class="flex justify-between gap-2">
      <FormControl class="h-11" label="Type" v-model="form.type" :options="typeOptions" />

      <FormControl
        label="Cost"
        prefix="€"
        type="number"
        min="0"
        step="1"
        v-model="form.cost"
        :error="form.errors.cost"
      />
    </div>

    <div class="flex justify-between gap-2">
      <FormControl label="Status" v-model="form.status" :options="statusOptions" fancy />

      <FormControl
        label="Approved at"
        type="datetime-local"
        v-model="form.approved_at"
        :error="form.errors.approved_at"
      />
    </div>
  </Form>
</template>
