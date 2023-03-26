<script setup>
import { useForm } from "@inertiajs/vue3";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const props = defineProps({
  payment: Object,
});

// TODO: this must be fetched from the server
const typeOptions = ["charge", "discount", "warranty", "refund"];
const methodOptions = ["cash", "card", "online"];

const form = useForm({
  ...props.payment,
    // TODO: see above
  amount: props.payment.amount ?? 0,
  type: props.payment.type ?? typeOptions[0],
  method: props.payment.method ?? methodOptions[0],
  notes: props.payment.notes,
});
</script>

<template>
  <Form :form="form" resource="payments">
    <FormControl
      label="Amount"
      type="number"
      v-model="form.amount"
      :error="form.errors.amount"
      required
      autofocus
    />
    <FormControl label="Type" v-model="form.type" :options="typeOptions" />
    <FormControl label="Method" v-model="form.method" :options="methodOptions" />
    <FormControl label="Notes" rows="3" v-model="form.notes" :error="form.errors.notes" />
  </Form>
</template>
