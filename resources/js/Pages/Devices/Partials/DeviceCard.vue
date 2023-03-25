<script setup>
import { formatDate } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import DeviceBadge from "./DeviceBadge.vue";

const props = defineProps({
  device: Object,
});
</script>

<template>
  <Card>
    <template #header>
      <h5>Device</h5>
      <DeviceBadge :status="device.status" />
    </template>

    <DescriptionList>
      <!-- TODO: Add the following fields as link -->
      <!-- customer_id: Owner -->
      <!-- user_id: Receiver -->

      <DescriptionListItem
        label="Customer"
        v-if="device.customer"
        :value="device.customer.name"
        :href="route('customers.show', device.customer.id)"
      />

      <DescriptionListItem label="Name" :value="device.name" />

      <DescriptionListItem
        label="Brand"
        :value="device.brand"
        :href="route('devices.index', { brand: device.brand })"
      />

      <DescriptionListItem
        label="Type"
        :value="device.type"
        :href="route('devices.index', { type: device.type })"
      />

      <DescriptionListItem
        v-if="device.serial"
        label="Serial Number"
        :value="device.serial"
      />

      <DescriptionListItem v-if="device.purchase_date" label="Purchase Date">
        {{ formatDate(device.purchase_date) }}
      </DescriptionListItem>

      <DescriptionListItem v-if="device.warranty_date" label="Warranty Expire Date">
        {{ formatDate(device.warranty_expire_date) }}
      </DescriptionListItem>

      <DescriptionListItem label="Created At" type="date" :value="device.created_at" />

      <DescriptionListItem label="Last Update" type="date" :value="device.updated_at" />

      <DescriptionListItem label="Last update by">
        {{ device.user.name }}
      </DescriptionListItem>
    </DescriptionList>
  </Card>
</template>
