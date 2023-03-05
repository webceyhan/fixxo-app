<script setup>
import UserBadge from "./UserBadge.vue";
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";

defineProps({
    users: Array,
});
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="user in users"
            :key="user.id"
            :href="route('users.show', user.id)"
        >
            <div class="w-full md:w-6/12">
                {{ user.name }}

                <div class="hidden md:block text-sm text-gray-400 mt-1">
                    {{ user.email }}
                </div>
            </div>

            <div class="hidden md:block w-2/12 text-gray-400">
                {{ user.role }}
            </div>

            <div
                v-if="user.assets_count"
                class="hidden md:block w-2/12 text-gray-400"
            >
                assets {{ user.assets_count }}
            </div>

            <div class="w-fit md:w-2/12">
                <UserBadge :status="user.status" />
            </div>
        </StackedListItem>
    </StackedList>
</template>
