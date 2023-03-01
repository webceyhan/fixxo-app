<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";
import FormControl from "@/Components/FormControl.vue";

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
    <AuthenticatedCrudLayout :title="task.name">
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
                <FormControl
                    label="Status"
                    v-model="form.status"
                    :options="statusOptions"
                />
            </Form>
        </section>
    </AuthenticatedCrudLayout>
</template>
