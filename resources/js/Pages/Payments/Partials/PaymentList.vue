<script setup>
import StackedList from "@/Components/List/StackedList.vue";
import StackedListItem from "@/Components/List/StackedListItem.vue";

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

                <span v-if="payment.user">
                    <br />
                    {{ payment.user.name }}
                </span>
            </span>

            <span v-if="payment.asset" class="w-2/5 text-gray-400">
                {{ payment.asset.name }}

                <span v-if="payment.asset.customer">
                    <br />
                    {{ payment.asset.customer.name }}
                </span>
            </span>

            <span class="w-fit text-gray-400"> {{ payment.amount }}€ </span>
        </StackedListItem>
    </StackedList>
</template>
