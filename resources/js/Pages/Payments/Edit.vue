<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/Form/Form.vue";
import Card from "@/Components/Card.vue";
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import FormControl from "@/Components/Form/FormControl.vue";

const props = defineProps({
    payment: Object,
    typeOptions: Array,
    methodOptions: Array,
});

const form = useForm({
    ...props.payment,
    amount: props.payment.amount,
    type: props.payment.type,
    method: props.payment.method,
    notes: props.payment.notes,
});
</script>

<template>
    <AuthenticatedLayout :title="payment.type">
        <Toolbar>
            <BackButton class="mr-auto" />
        </Toolbar>

        <Card>
            <section class="max-w-xl">
                <Form :form="form" resource="payments">
                    <FormControl
                        label="Amount"
                        type="number"
                        v-model="form.amount"
                        :error="form.errors.amount"
                        required
                        autofocus
                    />
                    <FormControl
                        label="Type"
                        v-model="form.type"
                        :options="typeOptions"
                    />
                    <FormControl
                        label="Method"
                        v-model="form.method"
                        :options="methodOptions"
                    />
                    <FormControl
                        label="Notes"
                        rows="3"
                        v-model="form.notes"
                        :error="form.errors.notes"
                    />
                </Form>
            </section>
        </Card>
    </AuthenticatedLayout>
</template>
