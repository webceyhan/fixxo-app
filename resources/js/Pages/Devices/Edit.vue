<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import CustomerCard from "@/Pages/Customers/Partials/CustomerCard.vue";

const props = defineProps({
  device: Object,
  typeOptions: Array,
  statusOptions: Array,
});

const form = useForm({
  ...props.device,
  model: props.device.model,
  brand: props.device.brand,
  type: props.device.type,
  serial_number: props.device.serial_number,
  purchase_date: props.device.purchase_date,
  warranty_expire_date: props.device.warranty_expire_date,
  status: props.device.status,
});
</script>

<template>
  <PageLayout :title="device.model" content-only-mobile>
    <template #aside>
      <CustomerCard :customer="device.customer" />
    </template>

    <template #content>
      <Card>
        <section class="max-w-xl">
          <Form :form="form" resource="devices">
            <FormControl
              label="Model"
              v-model="form.model"
              :error="form.errors.model"
              required
              autofocus
            />
            <FormControl label="Brand" v-model="form.brand" :error="form.errors.brand" />
            <FormControl label="Type" v-model="form.type" :options="typeOptions" />
            <FormControl
              label="Serial"
              v-model="form.serial_number"
              :error="form.errors.serial_number"
            />
            <FormControl
              label="Purchase Date"
              type="date"
              v-model="form.purchase_date"
              :error="form.errors.purchase_date"
            />
            <FormControl
              label="Warranty Expire Date"
              type="date"
              v-model="form.warranty_expire_date"
              :error="form.errors.warranty_expire_date"
            />
            <FormControl label="Status" v-model="form.status" :options="statusOptions" />
          </Form>
        </section>
      </Card>
    </template>
  </PageLayout>
</template>
