<script setup>
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

defineProps({
    payments: Array,
});
</script>

<template>
    <StackedList>
        <StackedListItem
            v-for="payment in payments"
            :key="payment.id"
            :href="route('payments.show', payment.id)"
        >
            <span class="w-1/5">
                {{ payment.type }}

                <br />

                {{ payment.user.name }}
            </span>

            <span class="w-2/5 text-gray-400">
                {{ payment.asset.name }}

                <br />

                {{ payment.asset.customer?.name }}
            </span>

            <span class="w-fit text-gray-400"> {{ payment.amount }}€ </span>
        </StackedListItem>
    </StackedList>
</template>
