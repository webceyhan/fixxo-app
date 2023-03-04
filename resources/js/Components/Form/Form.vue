<script setup>
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";

const props = defineProps({
    form: Object,
    resource: String,
});

const save = () => {
    const isUpdate = !!props.form?.id;
    const method = isUpdate ? "put" : "post";

    const url = isUpdate
        ? route(`${props.resource}.update`, props.form.id)
        : route(`${props.resource}.store`);

    props.form.submit(method, url);
};

const cancel = () => window.history.back();
</script>

<template>
    <form @submit.prevent="save" novalidate class="space-y-6">
        <slot />

        <slot name="actions">
            <div class="flex gap-6">
                <PrimaryButton label="Save" type="submit" />
                <SecondaryButton label="Cancel" @click="cancel" />
            </div>
        </slot>
    </form>
</template>
