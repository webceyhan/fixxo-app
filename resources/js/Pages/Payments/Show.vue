<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PaymentCard from "./Partials/PaymentCard.vue";
import AssetCard from "../Assets/Partials/AssetCard.vue";

const props = defineProps({
  payment: Object,
});

const breadcrumbs = [
  {
    label: props.payment.asset.customer.name,
    href: route("customers.show", props.payment.asset.customer.id),
  },
  { label: props.payment.asset.name, href: route("assets.show", props.payment.asset.id) },
  {
    label: "Payment",
  },
];
</script>

<template>
  <PageLayout :title="payment.type" :breadcrumbs="breadcrumbs" content-only-mobile>
    <template #toolbar>
      <SecondaryButton label="Edit" :href="route('payments.edit', payment.id)" />
      <DangerButton
        label="Delete"
        method="delete"
        :href="route('payments.destroy', payment.id)"
      />
    </template>

    <template #aside>
      <AssetCard :asset="payment.asset" />
    </template>

    <template #content>
      <PaymentCard :payment="payment" />
    </template>
  </PageLayout>
</template>
