<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import CustomerCard from "../Customers/Partials/CustomerCard.vue";

const props = defineProps({
  ticket: Object,
  statusOptions: Array,
});

const form = useForm({
  ...props.ticket,
  description: props.ticket.description,
  note: props.ticket.note,
  status: props.ticket.status,
});
</script>

<template>
  <PageLayout :title="`Ticket #${ticket.id}`" content-only-mobile>
    <template #aside>
      <CustomerCard :customer="ticket.customer" />
    </template>

    <template #content>
      <Card>
        <section class="max-w-xl">
          <Form :form="form" resource="tickets">
            <FormControl
              label="Description"
              rows="3"
              v-model="form.description"
              :error="form.errors.description"
            />
            <FormControl
              label="Note"
              rows="3"
              v-model="form.note"
              :error="form.errors.note"
            />
            <FormControl label="Status" v-model="form.status" :options="statusOptions" />
          </Form>
        </section>
      </Card>
    </template>
  </PageLayout>
</template>
