<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import TaskCard from "./Partials/TaskCard.vue";
import AssetCard from "../Assets/Partials/AssetCard.vue";

const props = defineProps({
  task: Object,
});

const breadcrumbs = [
  {
    label: props.task.asset.customer.name,
    href: route("customers.show", props.task.asset.customer.id),
  },
  { label: props.task.asset.name, href: route("assets.show", props.task.asset.id) },
  { label: 'Task' },
];
</script>

<template>
  <PageLayout :title="task.description" :breadcrumbs="breadcrumbs" content-only-mobile>
    <template #toolbar>
      <SecondaryButton label="Edit" :href="route('tasks.edit', task.id)" />
      <DangerButton
        label="Delete"
        method="delete"
        :href="route('tasks.destroy', task.id)"
      />
    </template>

    <template #aside>
      <AssetCard :asset="task.asset" />
    </template>

    <template #content>
      <TaskCard :task="task" />
    </template>
  </PageLayout>
</template>
