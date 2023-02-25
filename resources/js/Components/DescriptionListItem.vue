<script setup>
defineProps({
    label: String,
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
                    <slot name="value">{{ value }}</slot>
                </p>
            </div>
        </slot>
    </li>
</template>
