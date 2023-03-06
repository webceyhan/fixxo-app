<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import AssetCard from "../Assets/Partials/AssetCard.vue";


const props = defineProps({
  payment: Object,
  typeOptions: Array,
  methodOptions: Array,
});

const breadcrumbs = [
  
{
    label: props.payment.asset.customer.name,
    href: route("customers.show", props.payment.asset.customer.id),
  },
  { label: props.payment.asset.name, href: route("assets.show", props.payment.asset.id) },
  { label: 'Payment', href: route("payments.show", props.payment.id) },
  { label: "Edit" },
];

const form = useForm({
  ...props.payment,
  amount: props.payment.amount,
  type: props.payment.type,
  method: props.payment.method,
  notes: props.payment.notes,
});
</script>

<template>
  <PageLayout :title="payment.type" 
      :breadcrumbs="breadcrumbs"
  
  content-only-mobile>
    <template #aside>
      <AssetCard :asset="payment.asset" />
    </template>

    <template #content>
      <Card>
        <section class="max-w-xl">
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
            <FormControl
              label="Notes"
              rows="3"
              v-model="form.notes"
              :error="form.errors.notes"
            />
          </Form>
        </section>
      </Card>
    </template>
  </PageLayout>
</template>
