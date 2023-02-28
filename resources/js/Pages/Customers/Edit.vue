<script setup>
import { ref } from "vue";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";

const props = defineProps({
    customer: Object,
    statusOptions: Array,
});

const form = ref(null);

const config = {
    name: {
        label: "Name",
    },
    company: {
        label: "Company",
    },
    vat: {
        label: "VAT",
    },
    address: {
        label: "Address",
    },
    phone: {
        label: "Phone",
        type: "tel",
    },
    email: {
        label: "Email",
        type: "email",
    },
    notes: {
        label: "Notes",
        rows: 3,
    },
    status: {
        label: "Status",
        options: props.statusOptions,
    },
};
</script>

<template>
    <AuthenticatedCrudLayout :title="customer.name">
        <section class="max-w-xl">
            <Form
                ref="form"
                :data="customer"
                :config="config"
                resource="customers"
            />
        </section>
    </AuthenticatedCrudLayout>
</template>
