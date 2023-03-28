<script setup>
import { useForm } from "@inertiajs/vue3";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import RadioGroup from "@/Components/Form/RadioGroup.vue";

const props = defineProps({
  transaction: Object,
});

// TODO: this must be fetched from the server
const typeOptions = ["charge", "discount", "warranty", "refund"];
const methodOptions = ["cash", "card", "online"];

const form = useForm({
  ...props.transaction,
  // TODO: see above
  amount: props.transaction.amount ?? 0,
  type: props.transaction.type ?? typeOptions[0],
  method: props.transaction.method ?? methodOptions[0],
  note: props.transaction.note,
});
</script>

<template>
  <Form :form="form" resource="transactions">
    <FormControl label="Type" v-model="form.type" :options="typeOptions" fancy />

    <FormControl label="Method" v-model="form.method" :options="methodOptions" fancy />

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

    <FormControl label="Note" rows="3" v-model="form.note" :error="form.errors.note" />
  </Form>
</template>
