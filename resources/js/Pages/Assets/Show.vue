<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    asset: Object,
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
                <PrimaryButton
                    label="New Task"
                    :href="route('tasks.create')"
                    :data="{ asset_id: asset.id }"
                />
            </div>
        </template>

        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in asset"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
