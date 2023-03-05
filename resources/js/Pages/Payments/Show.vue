<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PaymentCard from "./Partials/PaymentCard.vue";

defineProps({
    payment: Object,
});
</script>

<template>
    <AuthenticatedLayout :title="payment.type">
        <Toolbar>
            <BackButton class="mr-auto" />

            <SecondaryButton
                label="Edit"
                :href="route('payments.edit', payment.id)"
            />
            <DangerButton
                label="Delete"
                method="delete"
                :href="route('payments.destroy', payment.id)"
            />
        </Toolbar>

        <PaymentCard :payment="payment" />
    </AuthenticatedLayout>
</template>
