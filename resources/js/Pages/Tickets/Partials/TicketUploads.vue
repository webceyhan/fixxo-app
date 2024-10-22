<script setup lang="ts">
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import imageCompression from "browser-image-compression";
import Spinner from "@/Components/Spinner.vue";
import Icon from "@/Components/Icon.vue";
import Card from "@/Components/Card.vue";

const props = defineProps<{
  ticket: any; // TODO: define Ticket type
}>();

const processing = ref(false);

const form = useForm({
  folder: `tickets/${props.ticket.id}`,
  images: [] as any[],
});

async function upload(event: Event) {
  // show processing
  processing.value = true;

  const target = event.target as HTMLInputElement;
  const files = Array.from(target.files ?? []);

  // set form data to compress images
  form.images = await Promise.all(files.map(compressImage));

  // send form
  form.post(route("uploads.store"), {
    onSuccess: () => updateIndex(),
    onFinish: () => (processing.value = false),
    preserveScroll: true,
  });

  // bugfix: we must reset input
  // otherwise we can't choose the same file twice
  target.value = "";
}

async function compressImage(imageFile: File) {
  try {
    return await imageCompression(imageFile, {
      maxSizeMB: 1,
      useWebWorker: true,
      maxWidthOrHeight: 1920,
    });
  } catch (error) {
    console.log(error);
  }
}

// Carousel /////////////////////////
const index = ref(0);
const fullScreen = ref(false);
const uploadedUrls = computed(() => props.ticket.uploaded_urls);
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
  <Card title="Uploads" flush>
    <!-- carousel -->
    <div class="relative backdrop-blur-md" :class="{ '!fixed inset-0 z-50': fullScreen }">
      <!-- Carousel wrapper -->
      <div class="overflow-hidden h-64 rounded-lg-" :class="{ '!h-screen': fullScreen }">
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
          class="flex justify-center items-center size-full bg-base-content/10"
        >
          <Icon name="image" class="text-5xl opacity-50" />
        </figure>
      </div>

      <!-- Slider controls -->

      <!-- upload button -->
      <div class="absolute top-0 left-0 z-30 p-2">
        <div class="relative overflow-hidden group">
          <button
            class="btn btn-circle btn-neutral"
            :class="{ 'btn-sm bg-opacity-50 border-0': !fullScreen }"
            @click="remove()"
          >
            <Icon name="cloud-arrow-up-fill" />
          </button>

          <input
            type="file"
            class="absolute block cursor-pointer opacity-0 inset-0"
            @change="upload($event)"
            accept="image/*"
            multiple
          />
        </div>
      </div>

      <template v-if="!isEmpty">
        <!-- previous button -->
        <div class="absolute top-[40%] left-0 z-30 p-2">
          <button
            class="btn btn-circle btn-neutral"
            :class="{ 'btn-sm bg-opacity-50 border-0': !fullScreen }"
            @click="prev()"
          >
            <Icon name="chevron-left" />
          </button>
        </div>

        <!-- next button -->
        <div class="absolute top-[40%] right-0 z-30 p-2">
          <button
            class="btn btn-circle btn-neutral"
            :class="{ 'btn-sm bg-opacity-50 border-0': !fullScreen }"
            @click="next()"
          >
            <Icon name="chevron-right" />
          </button>
        </div>

        <!-- full screen toggle -->
        <div class="absolute top-0 right-0 z-30 p-2">
          <button
            class="btn btn-circle btn-neutral"
            :class="{ 'btn-sm bg-opacity-50 border-0': !fullScreen }"
            @click="fullScreen = !fullScreen"
          >
            <Icon :name="fullScreen ? 'x-lg' : 'fullscreen'" />
          </button>
        </div>
      </template>

      <footer class="flex justify-center items-center absolute inset-x-0 bottom-1 z-30">
        <!-- remove button -->
        <button
          v-if="!isEmpty && !processing"
          class="btn btn-circle btn-neutral"
          :class="{ 'btn-sm bg-opacity-50 border-0': !fullScreen }"
          @click="remove()"
        >
          <Icon name="delete" />
        </button>

        <Spinner v-if="processing" />
      </footer>
    </div>
  </Card>
</template>
