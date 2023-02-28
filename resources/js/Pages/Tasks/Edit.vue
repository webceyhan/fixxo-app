<script setup>
import { ref } from "vue";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";

const props = defineProps({
    task: Object,
    statusOptions: Array,
});

const form = ref(null);

const config = {
    description: {
        label: "Description",
        rows: 3,
    },
    price: {
        label: "Price",
        type: "number",
    },
    status: {
        label: "Status",
        options: props.statusOptions,
    },
};
</script>

<template>
    <AuthenticatedCrudLayout :title="task.name">
        <section class="max-w-xl">
            <Form ref="form" :data="task" :config="config" resource="tasks" />
        </section>
    </AuthenticatedCrudLayout>
</template>
