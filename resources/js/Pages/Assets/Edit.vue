<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import CustomerCard from "../Customers/Partials/CustomerCard.vue";

const props = defineProps({
  asset: Object,
  typeOptions: Array,
  statusOptions: Array,
});

const { id, name, customer } = props.asset;

const breadcrumbs = [
  { label: customer.name, href: route("customers.show", customer.id) },
  ...(id
    ? [{ label: name, href: route("assets.show", id) }, { label: "Edit Asset" }]
    : [{ label: "New Asset" }]),
];

const form = useForm({
  ...props.asset,
  name: props.asset.name,
  brand: props.asset.brand,
  type: props.asset.type,
  serial: props.asset.serial,
  purchase_date: props.asset.purchase_date,
  warranty: props.asset.warranty,
  problem: props.asset.problem,
  notes: props.asset.notes,
  status: props.asset.status,
});
</script>

<template>
  <PageLayout :title="asset.name" :breadcrumbs="breadcrumbs" content-only-mobile>
    <template #aside>
      <CustomerCard :customer="asset.customer" />
    </template>

    <template #content>
      <Card>
        <section class="max-w-xl">
          <Form :form="form" resource="assets">
            <FormControl
              label="Name"
              v-model="form.name"
              :error="form.errors.name"
              required
              autofocus
            />
            <FormControl label="Brand" v-model="form.brand" :error="form.errors.brand" />
            <FormControl label="Type" v-model="form.type" :options="typeOptions" />
            <FormControl
              label="Serial"
              v-model="form.serial"
              :error="form.errors.serial"
            />
            <FormControl
              label="Purchase Date"
              type="date"
              v-model="form.purchase_date"
              :error="form.errors.purchase_date"
            />
            <FormControl
              label="Warranty"
              type="number"
              v-model="form.warranty"
              :error="form.errors.warranty"
            />
            <FormControl
              label="Problem"
              rows="3"
              v-model="form.problem"
              :error="form.errors.problem"
            />
            <FormControl
              label="Notes"
              rows="3"
              v-model="form.notes"
              :error="form.errors.notes"
            />
            <FormControl label="Status" v-model="form.status" :options="statusOptions" />
          </Form>
        </section>
      </Card>
    </template>
  </PageLayout>
</template>
