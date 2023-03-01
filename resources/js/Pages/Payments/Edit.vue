<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import Form from "@/Components/Form.vue";
import FormControl from "@/Components/FormControl.vue";
import Card from "@/Components/Card.vue";

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
    <AuthenticatedCrudLayout :title="payment.name">
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
    </AuthenticatedCrudLayout>
</template>
