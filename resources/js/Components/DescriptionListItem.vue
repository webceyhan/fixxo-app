<script setup>
import { formatDate, formatMoney, formatNumber } from "@/Shared/utils";

defineProps({
    label: String,
    type: String,
    value: [String, Number],
});
</script>

<template>
    <li class="flex p-4">
        <slot>
            <div class="w-full overflow-hidden sm:flex gap-x-4">
                <p class="w-1/5 text-slate-900 dark:text-slate-100 capitalize">
                    <slot name="label">{{ label }}</slot>
                </p>
                <p class="text-slate-500 dark:text-slate-400 truncate">
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
                </p>
            </div>
        </slot>
    </li>
</template>
