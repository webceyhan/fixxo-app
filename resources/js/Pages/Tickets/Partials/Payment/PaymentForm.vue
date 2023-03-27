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
  note: props.payment.note,
});
</script>

<template>
  <Form :form="form" resource="payments">
    <FormControl
      label="Amount"
      prefix="€"
      type="number"
      min="0"
      step="1"
      v-model="form.amount"
      :error="form.errors.amount"
      required
      autofocus
    />

    <FormControl label="Type" v-model="form.type" :options="typeOptions" />

    <FormControl label="Method" v-model="form.method" :options="methodOptions" />

    <FormControl label="Note" rows="3" v-model="form.note" :error="form.errors.note" />
  </Form>
</template>
