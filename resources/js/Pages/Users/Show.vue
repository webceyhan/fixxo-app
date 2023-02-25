<script setup>
import AuthenticatedCrudLayout from "@/Layouts/AuthenticatedCrudLayout.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";

defineProps({
    user: Object,
});
</script>

<template>
    <AuthenticatedCrudLayout :title="user.name">
        <DescriptionList>
            <DescriptionListItem
                v-for="(value, label) in user"
                :key="label"
                v-bind="{ label, value }"
            />
        </DescriptionList>
    </AuthenticatedCrudLayout>
</template>
