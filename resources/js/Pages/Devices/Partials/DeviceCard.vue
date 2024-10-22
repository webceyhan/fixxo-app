<script setup lang="ts">
import { computed } from "vue";
import { isPastDate } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import Field from "@/Components/Field/Field.vue";
import FieldGroup from "@/Components/Field/FieldGroup.vue";
import LinkField from "@/Components/Field/LinkField.vue";
import DateField from "@/Components/Field/DateField.vue";
import DeviceBadge from "./DeviceBadge.vue";
import WarrantyBadge from "./WarrantyBadge.vue";

const props = defineProps<{
  device: any; // TODO: define Device type
}>();

const warrantyStatus = computed(() => {
  const { warranty_expire_date } = props.device;

  return warranty_expire_date
    ? isPastDate(warranty_expire_date)
      ? "expired"
      : "valid"
    : "na";
});
</script>

<template>
  <Card>
    <template #header>
      Device

      <DeviceBadge :status="device.status" />
    </template>

    <FieldGroup>
      <!-- TODO: Add the following fields as link -->
      <!-- customer_id: Owner -->
      <!-- user_id: Receiver -->

      <LinkField
        v-if="device.customer"
        label="Customer"
        :href="route('customers.show', device.customer.id)"
        :value="device.customer.name"
      />

      <Field label="Model" :value="device.model" />

      <LinkField
        label="Brand"
        :href="route('devices.index', { brand: device.brand })"
        :value="device.brand"
      />

      <LinkField
        label="Type"
        :href="route('devices.index', { type: device.type })"
        :value="device.type"
      />

      <Field
        v-if="device.serial_number"
        label="Serial Number"
        :value="device.serial_number"
      />

      <DateField
        v-if="device.purchase_date"
        label="Purchase Date"
        :value="device.purchase_date"
      />

      <DateField label="Warranty Expire Date" :value="device.warranty_expire_date" short>
        <WarrantyBadge :status="warrantyStatus" />
      </DateField>

      <DateField label="Created At" :value="device.created_at" />

      <DateField label="Last Update" :value="device.updated_at" />
    </FieldGroup>
  </Card>
</template>
