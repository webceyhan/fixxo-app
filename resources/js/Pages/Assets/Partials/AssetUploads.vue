<script setup>
import { useForm } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";

const props = defineProps({
  asset: Object,
});

const form = useForm({
  asset_id: props.asset.id,
  images: [],
});

function send() {
  form.post(route("uploads.store"), {
    preserveScroll: true,
  });
}
</script>

<template>
  <Card label="Uploads">
    <form @submit.prevent="send()" class="space-y-4">
      <input type="file" multiple @input="form.images = $event.target.files" />
      <SecondaryButton type="submit">Upload</SecondaryButton>
    </form>

    <br />

    <div class="flex gap-1 overflow-x-scroll">
      <template v-for="url in props.asset.uploaded_urls">
        <img :src="url" class="w-20 h-20 object-cover" />
      </template>
    </div>
  </Card>
</template>
