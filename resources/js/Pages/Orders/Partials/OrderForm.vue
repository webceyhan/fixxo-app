<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { statusOptions } from "./shared";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import { mysqlToDatetimeLocal } from "@/Shared/utils";

const props = defineProps({
  order: Object,
});

const form = useForm({
  ...props.order,
  // TODO: see above
  name: props.order.name,
  url: props.order.url,
  quantity: props.order.quantity ?? 1,
  cost: props.order.cost ?? 0,
  is_billable: props.order.is_billable ?? false,
  status: props.order.status ?? statusOptions[0],
  approved_at: mysqlToDatetimeLocal(props.order.approved_at),
});

const formEl = ref(null);

defineExpose({
  save: () => formEl.value.save(),
});
</script>

<template>
  <Form :form="form" resource="orders" ref="formEl">
    <FormControl
      label="Name"
      v-model="form.name"
      :error="form.errors.name"
      required
      autofocus
    />

    <FormControl label="URL" v-model="form.url" :error="form.errors.url" />

    <div class="flex gap-4">
      <FormControl
        label="Quantity"
        type="number"
        min="1"
        step="1"
        v-model="form.quantity"
        :error="form.errors.quantity"
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
    </div>

    <FormControl label="Billable" type="checkbox" v-model="form.is_billable" />

    <FormControl label="Status" v-model="form.status" :options="statusOptions" fancy />

    <FormControl
      label="Approved at"
      type="datetime-local"
      v-model="form.approved_at"
      :error="form.errors.approved_at"
    />
  </Form>
</template>
