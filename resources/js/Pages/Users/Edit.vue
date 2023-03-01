<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";
import FormControl from "@/Components/FormControl.vue";

const props = defineProps({
    user: Object,
    roleOptions: Array,
    statusOptions: Array,
});

const form = useForm({
    ...props.user,
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
    status: props.user.status,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="user.name">
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
                    label="Email"
                    type="email"
                    v-model="form.email"
                    :error="form.errors.email"
                    required
                />
                <FormControl
                    label="Role"
                    v-model="form.role"
                    :options="roleOptions"
                />
                <FormControl
                    label="Status"
                    v-model="form.status"
                    :options="statusOptions"
                />
            </Form>
        </section>
    </AuthenticatedCrudLayout>
</template>
