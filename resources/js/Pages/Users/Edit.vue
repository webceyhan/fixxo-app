<script setup>
import { ref } from "vue";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";

const props = defineProps({
    user: Object,
    roleOptions: Array,
    statusOptions: Array,
});

const form = ref(null);

const config = {
    name: {
        label: "Name",
    },
    email: {
        type: "email",
        label: "Email",
    },
    role: {
        label: "Role",
        options: props.roleOptions,
    },
    status: {
        label: "Status",
        options: props.statusOptions,
    },
};
</script>

<template>
    <AuthenticatedCrudLayout :title="user.name">
        <section class="max-w-xl">
            <Form ref="form" :data="user" :config="config" resource="users" />
        </section>
    </AuthenticatedCrudLayout>
</template>
