<script setup>
import {
    formatDate,
    formatMoney,
    formatNumber,
    formatPhone,
} from "@/Shared/utils";

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

                    <!-- format as phone number -->
                    <a
                        v-else-if="type === 'phone'"
                        :href="`tel:${value}`"
                        class="text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-200 hover:text-indigo-800"
                    >
                        {{ formatPhone(value) }}
                    </a>

                    <!-- render as email -->
                    <a
                        v-else-if="type === 'email'"
                        :href="`mailto:${value}`"
                        class="text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-200 hover:text-indigo-800"
                    >
                        {{ value }}
                    </a>

                    <!-- render as location -->
                    <a
                        v-else-if="type === 'location'"
                        :href="`https://www.google.com/maps/place/${value}`"
                        target="_blank"
                        class="text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-200 hover:text-indigo-800"
                    >
                        {{ value }}
                    </a>

                    <!-- render as-is -->
                    <span v-else> {{ value }} </span>
                </slot>
            </dd>
        </slot>
    </div>
</template>
