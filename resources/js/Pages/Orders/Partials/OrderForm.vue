<script setup>
import { useForm } from "@inertiajs/vue3";
import { statusOptions } from "./shared";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";

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
  note: props.order.note,
  status: props.order.status,
});
</script>

<template>
  <Form :form="form" resource="orders">
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

    <FormControl label="Note" rows="3" v-model="form.note" :error="form.errors.note" />

    <FormControl label="Status" v-model="form.status" :options="statusOptions" fancy />
  </Form>
</template>
