<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import AssetCard from "../Assets/Partials/AssetCard.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const props = defineProps({
  payment: Object,
  typeOptions: Array,
  methodOptions: Array,
});

const form = useForm({
  ...props.payment,
  amount: props.payment.amount,
  type: props.payment.type,
  method: props.payment.method,
  notes: props.payment.notes,
});
</script>

<template>
  <PageLayout :title="payment.type" content-only-mobile>
    <template #toolbar>
      <DangerButton
        v-if="payment.id"
        label ="Delete"
        method="delete"
        :href="route('payments.destroy', payment.id)"
      />
    </template>

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
