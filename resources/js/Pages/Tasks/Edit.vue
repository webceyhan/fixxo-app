<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

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
    <AuthenticatedLayout :title="task.description">
        <Toolbar>
            <BackButton class="mr-auto" />
        </Toolbar>

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
                    <FormControl
                        label="Status"
                        v-model="form.status"
                        :options="statusOptions"
                    />
                </Form>
            </section>
        </Card>
    </AuthenticatedLayout>
</template>
