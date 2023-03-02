<script setup>
defineProps({
    label: String,
    flush: Boolean,
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <!-- header -->
        <header
            v-if="$slots.header || label"
            class="border-b-2 border-gray-200 dark:border-gray-700 p-4 sm:p-6"
        >
            <slot name="header">
                <div
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    {{ label }}
                </div>
            </slot>
        </header>

        <!-- body -->
        <div
            class="text-gray-900 dark:text-gray-100"
            :class="{ 'p-4 sm:p-6': !flush }"
        >
            <slot />
        </div>
    </div>
</template>
