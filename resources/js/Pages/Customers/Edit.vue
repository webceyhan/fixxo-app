<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/Form/Form.vue";
import FormControl from "@/Components/Form/FormControl.vue";
import Card from "@/Components/Card.vue";

const props = defineProps({
    customer: Object,
    statusOptions: Array,
});

const form = useForm({
    ...props.customer,
    name: props.customer.name,
    company: props.customer.company,
    vat: props.customer.vat,
    address: props.customer.address,
    phone: props.customer.phone,
    email: props.customer.email,
    notes: props.customer.notes,
    status: props.customer.status,
});
</script>

<template>
    <AuthenticatedLayout :title="customer.name">
        <Card>
            <section class="max-w-xl">
                <Form :form="form" resource="customers">
                    <FormControl
                        label="Name"
                        v-model="form.name"
                        :error="form.errors.name"
                        required
                        autofocus
                    />
                    <FormControl
                        label="Company"
                        v-model="form.company"
                        :error="form.errors.company"
                    />
                    <FormControl
                        label="VAT"
                        v-model="form.vat"
                        :error="form.errors.vat"
                    />
                    <FormControl
                        label="Address"
                        v-model="form.address"
                        :error="form.errors.address"
                    />
                    <FormControl
                        label="Phone"
                        type="tel"
                        v-model="form.phone"
                        :error="form.errors.phone"
                    />
                    <FormControl
                        label="Email"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                    />
                    <FormControl
                        label="Notes"
                        rows="3"
                        v-model="form.notes"
                        :error="form.errors.notes"
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
