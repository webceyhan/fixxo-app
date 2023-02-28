<script setup>
import { onMounted, ref } from "vue";

const input = ref(null);

defineProps(["modelValue", "options", "type"]);

defineEmits(["update:modelValue"]);

defineExpose({ focus: () => input.value.focus() });

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});
</script>

<template>
    <select
        ref="input"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <option
            v-for="(option, key) in options"
            :key="key"
            :value="option ?? key"
        >
            {{ option ?? key }}
        </option>
    </select>
</template>
