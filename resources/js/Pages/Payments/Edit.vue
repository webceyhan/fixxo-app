<script setup>
import { ref } from "vue";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";

const props = defineProps({
    payment: Object,
    typeOptions: Array,
    methodOptions: Array,
});

const form = ref(null);

const config = {
    amount: {
        label: "Amount",
        type: "number",
    },
    type: {
        label: "Type",
        options: props.typeOptions,
    },
    method: {
        label: "Method",
        options: props.methodOptions,
    },
    notes: {
        label: "Notes",
        rows: 3,
    },
};
</script>

<template>
    <AuthenticatedCrudLayout :title="payment.name">
        <section class="max-w-xl">
            <Form
                ref="form"
                :data="payment"
                :config="config"
                resource="payments"
            />
        </section>
    </AuthenticatedCrudLayout>
</template>
