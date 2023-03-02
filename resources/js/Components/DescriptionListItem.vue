<script setup>
import { formatDate, formatMoney, formatNumber } from "@/Shared/utils";

defineProps({
    label: String,
    type: String,
    value: [String, Number],
});
</script>

<template>
    <div class="flex flex-col lg:flex-row overflow-hidden gap-2 py-4">
        <slot>
            <dt class="sm:w-2/5 text-gray-500 dark:text-gray-400 capitalize">
                <slot name="label">{{ label }}</slot>
            </dt>

            <dd class="sm:w-3/5 text-gray-900 dark:text-gray-100 truncate">
                <slot name="value">
                    <!-- format as date / datetime -->
                    <span v-if="type === 'date'">
                        {{ formatDate(value) }}
                    </span>

                    <!-- format as money -->
                    <span v-else-if="type === 'money'">
                        {{ formatMoney(value) }}
                    </span>

                    <!-- format as number -->
                    <span v-else-if="type === 'number'">
                        {{ formatNumber(value) }}
                    </span>

                    <!-- format as string -->
                    <span v-else> {{ value }} </span>
                </slot>
            </dd>
        </slot>
    </div>
</template>
