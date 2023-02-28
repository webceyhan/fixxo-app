<script setup>
import { ref } from "vue";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";

const props = defineProps({
    asset: Object,
    typeOptions: Array,
    statusOptions: Array,
});

const form = ref(null);

const config = {
    name: {
        label: "Name",
    },
    brand: {
        label: "Brand",
    },
    type: {
        label: "Type",
        options: props.typeOptions,
    },
    serial: {
        label: "Serial",
    },
    purchase_date: {
        label: "Purchase Date",
        type: "date",
    },
    warranty: {
        label: "Warranty",
        type: "number",
    },
    problem: {
        label: "Problem",
        rows: 3,
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
    <AuthenticatedCrudLayout :title="asset.name">
        <section class="max-w-xl">
            <Form ref="form" :data="asset" :config="config" resource="assets" />
        </section>
    </AuthenticatedCrudLayout>
</template>
