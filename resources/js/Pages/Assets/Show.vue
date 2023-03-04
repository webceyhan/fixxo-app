<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Card from "@/Components/Card.vue";
import TaskList from "../Tasks/Partials/TaskList.vue";
import PaymentList from "../Payments/Partials/PaymentList.vue";
import Textarea from "@/Components/Form/Textarea.vue";

const props = defineProps({
    asset: Object,
    tasks: Array,
    payments: Array,
});

const form = useForm({
    notes: props.asset.notes,
});

const save = () => {
    form.put(route("assets.update", props.asset.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout :title="asset.name">
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

        <div class="flex flex-col lg:flex-row items-start gap-4">
            <div class="flex flex-col w-full lg:w-1/3 gap-4">
                <Card label="Overview">
                    <DescriptionList>
                        <!-- TODO: Add the following fields as link -->
                        <!-- customer_id: Owner -->
                        <!-- user_id: Receiver -->

                        <DescriptionListItem label="Name" :value="asset.name" />

                        <DescriptionListItem
                            label="Brand"
                            :value="asset.brand"
                        />

                        <DescriptionListItem label="Type" :value="asset.type" />

                        <DescriptionListItem
                            v-if="asset.serial_number"
                            label="Serial Number"
                            :value="asset.serial_number"
                        />

                        <!-- TODO: if purchase_date present, show warranty status
                        based on the calculated warranty date -->
                        <DescriptionListItem
                            v-if="asset.purchase_date"
                            label="Purchase Date"
                            type="date"
                            :value="asset.purchase_date"
                        />

                        <DescriptionListItem
                            v-if="asset.warranty"
                            label="Warranty"
                            :value="asset.warranty"
                        />

                        <DescriptionListItem
                            label="Status"
                            :value="asset.status"
                        />

                        <DescriptionListItem
                            label="Created At"
                            type="date"
                            :value="asset.created_at"
                        />

                        <DescriptionListItem
                            v-if="asset.returned_at"
                            label="Returned At"
                            type="date"
                            :value="asset.returned_at"
                        />

                        <DescriptionListItem
                            label="Last Update"
                            type="date"
                            :value="asset.updated_at"
                        />
                    </DescriptionList>
                </Card>

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
                <Card label="Problem">
                    {{ asset.problem }}
                </Card>

                <Card label="Tasks" flush>
                    <TaskList :tasks="tasks" />
                </Card>

                <Card label="Payments" flush>
                    <PaymentList :payments="payments" />
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
