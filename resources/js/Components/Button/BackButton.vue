<script setup>
import SecondaryButton from "./SecondaryButton.vue";

const back = () => window.history.back();
</script>

<template>
    <SecondaryButton @click="back" class="gap-2">
        <slot>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4 -ml-1"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 19.5L8.25 12l7.5-7.5"
                />
            </svg>

            <span class="hidden md:inline"> Back </span>
        </slot>
    </SecondaryButton>
</template>
