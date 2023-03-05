<script>
let index = 0;
</script>

<script setup>
import { onMounted, ref } from "vue";

const id = `radio-group-${index++}`;

const input = ref(null);

defineProps({
    modelValue: [String, Number, Boolean],
    options: Object,
});

defineEmits(["change", "update:modelValue"]);

defineExpose({ focus: () => input.value.focus() });

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});
</script>

<template>
    <div ref="input" class="flex flex-col md:flex-row gap-1 md:gap-5">
        <label
            v-for="(option, key) in options"
            :key="key"
            class="inline-flex items-center mt-3 sm:m-0"
        >
            <input
                type="radio"
                :name="id"
                :value="key"
                :checked="key === modelValue"
                @change="$emit('update:modelValue', $event.target.value)"
                class="form-radio h-5 w-5 text-gray-600"
            />
            <span class="ml-2 text-gray-500">
                {{ option ?? key }}
            </span>
        </label>
    </div>
</template>
