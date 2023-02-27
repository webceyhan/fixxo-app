<script setup>
import Card from "./Card.vue";

defineProps({
    label: String,
    items: { type: Array, default: () => [] },
});
</script>

<template>
    <Card class="border-slate-500 border-l-4">
        <h2
            v-if="label"
            class="font-semibold uppercase text-lg text-gray-400 leading-tight mb-6"
        >
            {{ label }}
        </h2>

        <slot>
            <dl
                class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:divide-x divide-slate-500"
            >
                <div
                    v-for="(item, i) in items"
                    :key="i"
                    class="flex justify-between items-center sm:items-start sm:flex-col-reverse first:p-0 sm:pl-8"
                >
                    <dt class="text-base leading-7 dark:text-gray-400">
                        {{ item.label }}
                    </dt>
                    <dd
                        class="text-2xl font-bold leading-9 tracking-tight dark:text-white"
                    >
                        {{ item.value }}
                    </dd>
                </div>
            </dl>
        </slot>
    </Card>
</template>
