<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Card from "@/Components/Card.vue";
import TaskList from "../Tasks/Partials/TaskList.vue";
import PaymentList from "../Payments/Partials/PaymentList.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import AssetCard from "./Partials/AssetCard.vue";

const props = defineProps({
  asset: Object,
  tasks: Array,
  payments: Array,
});

const { name, customer } = props.asset;

const breadcrumbs = [
  { label: customer.name, href: route("customers.show", customer.id) },
  { label: name },
];

const form = useForm({
  notes: props.asset.notes,
});

const save = () => {
  form.put(route("assets.update", props.asset.id), {
    preserveScroll: true,
  });
};
</script>

<template>
  <PageLayout :title="asset.name" :breadcrumbs="breadcrumbs">
    <template #toolbar>
      <SecondaryButton label="Edit" :href="route('assets.edit', asset.id)" />
      <DangerButton
        label="Delete"
        method="delete"
        :href="route('assets.destroy', asset.id)"
        class="mr-4"
      />
      <PrimaryButton
        label="New Task"
        :href="route('tasks.create')"
        :data="{ asset_id: asset.id }"
      />
      <PrimaryButton
        label="New Payment"
        :href="route('payments.create')"
        :data="{ asset_id: asset.id }"
      />
    </template>

    <template #aside>
      <AssetCard :asset="asset" />

      <Card label="Notes">
        <Textarea
          rows="5"
          class="w-full"
          placeholder="Add notes..."
          v-model="form.notes"
        />
        <SecondaryButton label="Save" @click="save" />
      </Card>
    </template>

    <template #content>
      <Card label="Problem">
        {{ asset.problem }}
      </Card>

      <Card label="Tasks" flush>
        <TaskList :tasks="tasks" />
      </Card>

      <Card label="Payments" flush>
        <PaymentList :payments="payments" />
      </Card>
    </template>
  </PageLayout>
</template>
