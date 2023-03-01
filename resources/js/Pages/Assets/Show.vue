<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Card from "@/Components/Card.vue";
import TaskList from "../Tasks/Partials/TaskList.vue";
import PaymentList from "../Payments/Partials/PaymentList.vue";

defineProps({
    asset: Object,
    tasks: Array,
    payments: Array,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="asset.name">
        <template #actions>
            <div class="flex justify-end items-center gap-4">
                <SecondaryButton
                    label="Edit"
                    :href="route('assets.edit', asset.id)"
                />
                <DangerButton
                    label="Delete"
                    method="delete"
                    :href="route('assets.destroy', asset.id)"
                    class="mr-5"
                />
                <PrimaryButton
                    label="New Task"
                    :href="route('tasks.create')"
                    :data="{ asset_id: asset.id }"
                />
                <PrimaryButton
                    label="New Payment"
                    :href="route('payments.create')"
                    :data="{ asset_id: asset.id }"
                />
            </div>
        </template>

        <div class="flex flex-col lg:flex-row items-start gap-4">
            <div class="w-full lg:w-1/3">
                <Card>
                    <DescriptionList>
                        <DescriptionListItem
                            v-for="(value, label) in asset"
                            :key="label"
                            v-bind="{ label, value }"
                        />
                    </DescriptionList>
                </Card>
            </div>

            <div class="w-full lg:w-2/3 flex flex-col gap-4">
                <Card label="Tasks">
                    <TaskList :tasks="tasks" />
                </Card>

                <Card label="Payments">
                    <PaymentList :payments="payments" />
                </Card>
            </div>
        </div>
    </AuthenticatedCrudLayout>
</template>
