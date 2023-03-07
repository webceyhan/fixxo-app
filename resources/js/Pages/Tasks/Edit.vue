<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import AssetCard from "../Assets/Partials/AssetCard.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const props = defineProps({
  task: Object,
  statusOptions: Array,
});

const form = useForm({
  ...props.task,
  description: props.task.description,
  price: props.task.price,
  status: props.task.status,
});
</script>

<template>
  <PageLayout :title="task.description" content-only-mobile>
    <template #toolbar>
      <DangerButton
        v-if="task.id"
        label="Delete"
        icon="delete"
        method="delete"
        :href="route('tasks.destroy', task.id)"
      />
    </template>

    <template #aside>
      <AssetCard :asset="task.asset" />
    </template>

    <template #content>
      <Card>
        <section class="max-w-xl">
          <Form :form="form" resource="tasks">
            <FormControl
              label="Description"
              rows="3"
              v-model="form.description"
              :error="form.errors.description"
              required
              autofocus
            />
            <FormControl
              label="Price"
              type="number"
              v-model="form.price"
              :error="form.errors.price"
            />
            <FormControl label="Status" v-model="form.status" :options="statusOptions" />
          </Form>
        </section>
      </Card>
    </template>
  </PageLayout>
</template>
