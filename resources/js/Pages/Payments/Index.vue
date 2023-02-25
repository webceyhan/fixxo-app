<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";

defineProps({
    payments: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout title="Payments">
        <ul class="divide-y divide-slate-200">
            <li v-for="payment in payments" :key="payment.id">
                <Link
                    :href="route('payments.show', payment.id)"
                    class="flex p-4 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    {{ payment.type }} - 
                    {{ payment.amount }}€
                </Link>
            </li>
        </ul>
    </AuthenticatedCrudLayout>
</template>
