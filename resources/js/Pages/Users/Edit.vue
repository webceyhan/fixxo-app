<script setup>
import { useForm } from "@inertiajs/vue3";
import PageLayout from "@/Layouts/PageLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import UserCard from "./Partials/UserCard.vue";

const props = defineProps({
  user: Object,
  roleOptions: Array,
  statusOptions: Array,
});

const form = useForm({
  ...props.user,
  name: props.user.name,
  phone: props.user.phone,
  email: props.user.email,
  role: props.user.role,
  status: props.user.status,
});
</script>

<template>
  <PageLayout :title="user.name" content-only-mobile>
    <template #aside>
      <UserCard :user="user" />
    </template>

    <template #content>
      <Card>
        <section class="max-w-xl">
          <Form resource="users" :form="form">
            <FormControl
              label="Name"
              v-model="form.name"
              :error="form.errors.name"
              required
              autofocus
            />
            <FormControl
              label="Phone"
              type="tel"
              v-model="form.phone"
              :error="form.errors.phone"
            />
            <FormControl
              label="Email"
              type="email"
              v-model="form.email"
              :error="form.errors.email"
              required
            />
            <FormControl label="Role" v-model="form.role" :options="roleOptions" />
            <FormControl label="Status" v-model="form.status" :options="statusOptions" />
          </Form>
        </section>
      </Card>
    </template>
  </PageLayout>
</template>
