<script setup>
import Card from "@/Components/Card.vue";
import Field from "@/Components/Field/Field.vue";
import FieldGroup from "@/Components/Field/FieldGroup.vue";
import LinkField from "@/Components/Field/LinkField.vue";
import DateField from "@/Components/Field/DateField.vue";

const props = defineProps({
  customer: Object,
});
</script>

<template>
  <Card>
    <template #header> Customer </template>

    <FieldGroup>
      <Field label="Name" :value="customer.name" />

      <Field v-if="customer.company" label="Company" :value="customer.company" />

      <Field v-if="customer.vat_number" label="VAT Number" :value="customer.vat_number" />

      <LinkField v-if="customer.phone" label="Phone" :value="customer.phone" phone />

      <LinkField v-if="customer.email" label="Email" :value="customer.email" email />

      <LinkField
        v-if="customer.address"
        label="Address"
        :value="customer.address"
        location
      />

      <DateField label="Created At" :value="customer.created_at" />

      <DateField label="Last Update" :value="customer.updated_at" />
    </FieldGroup>
  </Card>
</template>
