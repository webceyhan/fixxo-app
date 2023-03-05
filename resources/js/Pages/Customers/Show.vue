<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from "@/Components/Card.vue";
import AssetList from "../Assets/Partials/AssetList.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import CustomerCard from "./Partials/CustomerCard.vue";

const props = defineProps({
    customer: Object,
    assets: Array,
});

const form = useForm({
    notes: props.customer.notes,
});

const save = () => {
    form.put(route("customers.update", props.customer.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout :title="customer.name">
        <Toolbar>
            <BackButton class="mr-auto" />

            <SecondaryButton
                label="Edit"
                :href="route('customers.edit', customer.id)"
            />
            <DangerButton
                label="Delete"
                method="delete"
                :href="route('customers.destroy', customer.id)"
                class="mr-4"
            />
            <PrimaryButton
                label="New Asset"
                :href="route('assets.create')"
                :data="{ customer_id: customer.id }"
            />
        </Toolbar>

        <div class="flex flex-col lg:flex-row items-start gap-4">
            <div class="flex flex-col w-full lg:w-1/3 gap-4">
                <CustomerCard :customer="customer" />

                <Card label="Notes">
                    <Textarea
                        rows="5"
                        class="w-full"
                        placeholder="Add notes..."
                        v-model="form.notes"
                    />
                    <SecondaryButton label="Save" @click="save" />
                </Card>
            </div>

            <div class="w-full lg:w-2/3 flex flex-col gap-4">
                <Card label="Assets" flush>
                    <AssetList :assets="assets" />
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
