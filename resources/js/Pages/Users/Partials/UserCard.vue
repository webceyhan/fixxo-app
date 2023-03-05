<script setup>
import Card from "@/Components/Card.vue";
import DescriptionList from "@/Components/List/DescriptionList.vue";
import DescriptionListItem from "@/Components/List/DescriptionListItem.vue";
import UserBadge from "./UserBadge.vue";

defineProps({
    user: Object,
});
</script>

<template>
    <Card label="User">
        <DescriptionList>
            <DescriptionListItem label="Name" :value="user.name" />

            <!-- TODO: add phone number to db -->

            <DescriptionListItem
                label="Email"
                type="email"
                :value="user.email"
            />

            <DescriptionListItem label="Role" :value="user.role" />

            <DescriptionListItem label="Status">
                <UserBadge :status="user.status" />
            </DescriptionListItem>

            <DescriptionListItem
                v-if="user.email_verified_at"
                label="Email Verified At"
                type="date"
                :value="user.email_verified_at"
            />

            <DescriptionListItem
                label="Created At"
                type="date"
                :value="user.created_at"
            />

            <DescriptionListItem
                label="Last Update"
                type="date"
                :value="user.updated_at"
            />
        </DescriptionList>
    </Card>
</template>
