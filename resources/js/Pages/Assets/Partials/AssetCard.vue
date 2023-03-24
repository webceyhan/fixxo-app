<script setup>
import { formatDate } from "@/Shared/utils";
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import AssetBadge from "./AssetBadge.vue";

const props = defineProps({
  asset: Object,
});
</script>

<template>
  <Card>
    <template #header>
      <div class="w-full relative flex justify-end">
        <h5 class="absolute left-0">
          <span class="mr-2">Asset</span>
          <AssetBadge :status="asset.status" />
        </h5>

        <img
          :src="asset.qr_url"
          class="z-10 w-10 h-auto -my-2 hover:my-0 hover:w-full opacity-50 hover:opacity-100 transition-all duration-200"
        />
      </div>
    </template>

    <DescriptionList>
      <!-- TODO: Add the following fields as link -->
      <!-- customer_id: Owner -->
      <!-- user_id: Receiver -->

      <DescriptionListItem
        label="Customer"
        v-if="asset.customer"
        :value="asset.customer.name"
        :href="route('customers.show', asset.customer.id)"
      />

      <DescriptionListItem label="Name" :value="asset.name" />

      <DescriptionListItem
        label="Brand"
        :value="asset.brand"
        :href="route('assets.index', { brand: asset.brand })"
      />

      <DescriptionListItem
        label="Type"
        :value="asset.type"
        :href="route('assets.index', { type: asset.type })"
      />

      <DescriptionListItem
        v-if="asset.serial_number"
        label="Serial Number"
        :value="asset.serial_number"
      />

      <!-- TODO: if purchase_date present, show warranty status
                        based on the calculated warranty date -->
      <DescriptionListItem v-if="asset.purchase_date" label="Purchase Date">
        {{ formatDate(asset.purchase_date) }}
      </DescriptionListItem>

      <DescriptionListItem v-if="asset.warranty_date" label="Warranty Expire Date">
        {{ formatDate(asset.warranty_date) }}
      </DescriptionListItem>

      <DescriptionListItem label="Created At" type="date" :value="asset.created_at" />

      <DescriptionListItem
        v-if="asset.returned_at"
        label="Returned At"
        type="date"
        :value="asset.returned_at"
      />

      <DescriptionListItem label="Last Update" type="date" :value="asset.updated_at" />

      <DescriptionListItem label="Last update by">
        {{ asset.user.name }}
      </DescriptionListItem>
    </DescriptionList>
  </Card>
</template>
