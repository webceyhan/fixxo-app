<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Card from "@/Components/Card.vue";
import AssetList from "../Assets/Partials/AssetList.vue";

defineProps({
    customer: Object,
    assets: Array,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="customer.name">
        <template #actions>
            <div class="flex justify-end items-center gap-4">
                <SecondaryButton
                    label="Edit"
                    :href="route('customers.edit', customer.id)"
                />
                <DangerButton
                    label="Delete"
                    method="delete"
                    :href="route('customers.destroy', customer.id)"
                    class="mr-5"
                />
                <PrimaryButton
                    label="New Asset"
                    :href="route('assets.create')"
                    :data="{ customer_id: customer.id }"
                />
            </div>
        </template>

        <div class="flex flex-col lg:flex-row items-start gap-4">
            <div class="flex flex-col w-full lg:w-1/3 gap-4">
                <Card label="Overview">
                    <DescriptionList>
                        <DescriptionListItem
                            label="Name"
                            :value="customer.name"
                        />

                        <DescriptionListItem
                            v-if="customer.company"
                            label="Company"
                            :value="customer.company"
                        />

                        <DescriptionListItem
                            v-if="customer.vat"
                            label="VAT"
                            :value="customer.vat"
                        />

                        <DescriptionListItem
                            label="Phone"
                            :value="customer.phone"
                        />

                        <DescriptionListItem
                            label="Email"
                            :value="customer.email"
                        />

                        <DescriptionListItem
                            label="Address"
                            :value="customer.address"
                        />

                        <DescriptionListItem
                            label="Status"
                            :value="customer.status"
                        />

                        <DescriptionListItem
                            label="Created At"
                            type="date"
                            :value="customer.created_at"
                        />

                        <DescriptionListItem
                            label="Last Update"
                            type="date"
                            :value="customer.updated_at"
                        />
                    </DescriptionList>
                </Card>

                <Card label="Notes">
                    {{ customer.notes }}
                </Card>
            </div>

            <div class="w-full lg:w-2/3 flex flex-col gap-4">
                <Card label="Assets">
                    <AssetList :assets="assets" />
                </Card>
            </div>
        </div>
    </AuthenticatedCrudLayout>
</template>
