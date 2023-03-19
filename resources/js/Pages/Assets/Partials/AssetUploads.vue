<script setup>
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import Card from "@/Components/Card.vue";

const props = defineProps({
  asset: Object,
});

const form = useForm({
  asset_id: props.asset.id,
  images: [],
});

function send(event) {
  form.images = event.target.files;
  form.post(route("uploads.store"), {
    onSuccess: () => updateIndex(),
    preserveScroll: true,
  });

  // bugfix: we must reset input
  // otherwise we can't choose the same file twice
  event.target.value = "";
}

// Carousel /////////////////////////
const index = ref(0);
const fullScreen = ref(false);
const uploadedUrls = computed(() => props.asset.uploaded_urls);
const isEmpty = computed(() => uploadedUrls.value.length === 0);

function prev() {
  const length = uploadedUrls.value.length;
  index.value = index.value > 0 ? index.value - 1 : length - 1;
}

function next() {
  const length = uploadedUrls.value.length;
  index.value = index.value < length - 1 ? index.value + 1 : 0;
}

function remove() {
  router.delete(route("uploads.destroy"), {
    data: { url: uploadedUrls.value[index.value] },
    onSuccess: () => updateIndex(),
    preserveScroll: true,
  });
}

// bugfix: we must update index to force ui pointing
// to the right image after add / remove
function updateIndex() {
  index.value--;
  index.value = index.value < 0 ? 0 : index.value;
}
</script>

<template>
  <Card label="Uploads">
    <!-- carousel -->
    <div class="relative backdrop-blur-md" :class="{ '!fixed inset-0 z-50': fullScreen }">
      <!-- Carousel wrapper -->
      <div
        class="overflow-hidden h-64 rounded-lg"
        :class="{ '!h-screen': fullScreen }"
      >
        <template v-for="(url, i) in uploadedUrls" :key="i">
          <img
            :src="url"
            class="w-full h-full object-cover"
            :class="{
              hidden: index !== i,
              '!object-contain': fullScreen,
            }"
          />
        </template>

        <!-- placeholder if empty -->
        <figure
          v-if="isEmpty"
          class="flex justify-center items-center w-full h-full bg-gray-500/20"
        >
          <Icon name="image" class="text-5xl text-gray-400/20" />
        </figure>
      </div>

      <!-- Slider controls -->

      <!-- previous -->
      <button
        v-if="!isEmpty"
        type="button"
        class="flex absolute top-0 left-0 z-30 justify-center items-center px-2 h-full cursor-pointer group focus:outline-none"
        @click="prev()"
      >
        <span
          class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-800/25 group-hover:bg-white/50 dark:group-hover:bg-gray-800/50"
          :class="{ '!w-16 !h-16 text-3xl': fullScreen }"
        >
          <Icon name="chevron-left" />
        </span>
      </button>

      <!-- next -->
      <button
        v-if="!isEmpty"
        type="button"
        class="flex absolute top-0 right-0 z-30 justify-center items-center px-2 h-full cursor-pointer group focus:outline-none"
        @click="next()"
      >
        <span
          class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-800/25 group-hover:bg-white/50 dark:group-hover:bg-gray-800/50"
          :class="{ '!w-16 !h-16 text-3xl': fullScreen }"
        >
          <Icon name="chevron-right" />
        </span>
      </button>

      <!-- upload button -->
      <div class="absolute top-0 left-0 z-30 p-2">
        <div class="relative overflow-hidden group">
          <button
            type="button"
            class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-800/25 group-hover:bg-white/50 dark:group-hover:bg-gray-800/50 focus:outline-none"
            :class="{ '!w-16 !h-16 text-3xl': fullScreen }"
            @click="remove()"
          >
            <Icon name="cloud-arrow-up-fill" />
          </button>

          <input
            type="file"
            class="absolute block cursor-pointer opacity-0 inset-0"
            @change="send($event)"
            multiple
          />
        </div>
      </div>

      <!-- full screen toggle -->
      <button
        v-if="!isEmpty"
        type="button"
        class="absolute top-0 right-0 z-30 p-2"
        @click="fullScreen = !fullScreen"
      >
        <span
          class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-800/25 hover:bg-white/50 dark:hover:bg-gray-800/50"
          :class="{ '!w-16 !h-16 text-3xl': fullScreen }"
        >
          <Icon :name="fullScreen ? 'x-lg' : 'fullscreen'" />
        </span>
      </button>

      <footer
        class="flex justify-center items-center absolute left-0 right-0 bottom-1 z-30"
      >
        <!-- remove button -->
        <button
          v-if="!isEmpty"
          type="button"
          class="inline-flex justify-center items-center w-8 h-8 rounded-full bg-white/30 dark:bg-gray-800/25 hover:bg-white/50 dark:hover:bg-gray-800/50 focus:outline-none"
          :class="{ '!w-16 !h-16 text-3xl': fullScreen }"
          @click="remove()"
        >
          <Icon name="delete" />
        </button>
      </footer>
    </div>
  </Card>
</template>
