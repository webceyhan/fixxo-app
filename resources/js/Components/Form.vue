<script setup>
import { useForm } from "@inertiajs/vue3";
import FormControl from "@/Components/FormControl.vue";
import PrimaryButton from "./PrimaryButton.vue";
import SecondaryButton from "./SecondaryButton.vue";

const props = defineProps({
    data: Object,
    config: Object,
    resource: String,
});

const form = useForm({
    ...props.data, // add hidden fields too..
    ...Object.keys(props.config).reduce(
        (acc, key) => ({ ...acc, [key]: props.data[key] }),
        {}
    ),
});

const save = () => {
    const isUpdate = !!props.data?.id;
    const method = isUpdate ? "put" : "post";

    const url = isUpdate
        ? route(`${props.resource}.update`, props.data.id)
        : route(`${props.resource}.store`);

    form.submit(method, url);
};

const cancel = () => window.history.back();

defineExpose({ save, cancel });
</script>

<template>
    <form @submit.prevent="save" novalidate class="space-y-6">
        <FormControl
            v-for="(attrs, key) in config"
            :key="key"
            v-bind="attrs"
            v-model="form[key]"
            :error="form.errors[key]"
        />

        <slot name="actions">
            <div class="flex gap-6">
                <PrimaryButton label="Save" />
                <SecondaryButton label="Cancel" @click="cancel" />
            </div>
        </slot>
    </form>
</template>
