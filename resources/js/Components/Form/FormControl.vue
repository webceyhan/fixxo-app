<script>
let index = 0;

export default {
    inheritAttrs: false,
};
</script>

<script setup>
import { ref, useAttrs, computed } from "vue";
import Select from "./Select.vue";
import Textarea from "./Textarea.vue";
import TextInput from "./TextInput.vue";
import InputLabel from "./InputLabel.vue";
import InputError from "./InputError.vue";

const id = `form-control-${index++}`;

const input = ref(null);

const props = defineProps({
    label: String,
    error: String,
});

const attrs = computed(() => ({
    id,
    name: id,
    ...useAttrs(),
}));

defineExpose({
    focus: () => input.value.focus(),
});
</script>

<template>
    <div>
        <InputLabel :for="id" :value="label" />

        <Select ref="input" v-if="$attrs.options" v-bind="attrs" class="mt-1 block w-full"/>

        <Textarea ref="input" v-else-if="$attrs.rows" v-bind="attrs" class="mt-1 block w-full"/>

        <TextInput ref="input" v-else v-bind="attrs" class="mt-1 block w-full"/>

        <InputError :message="error" class="mt-2"/>
    </div>
</template>
