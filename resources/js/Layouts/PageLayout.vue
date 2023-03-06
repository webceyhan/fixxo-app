<script setup>
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import Breadcrumbs from "@/Layouts/Partials/Breadcrumbs.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
  title: String,
  breadcrumbs: Array,
  contentOnlyMobile: Boolean,
});
</script>

<template>
  <AuthenticatedLayout :title="title">
    
    <Toolbar>
      <div class="mr-auto">
        <BackButton class="lg:hidden" />
        <Breadcrumbs :links="breadcrumbs" class="hidden lg:flex" />
      </div>

      <slot name="toolbar" />
    </Toolbar>

    <slot>
      <div class="flex flex-col lg:flex-row items-start gap-4">
        <!-- // aside -->
        <aside
          :class="{
            flex: !contentOnlyMobile,
            'hidden sm:flex': contentOnlyMobile,
          }"
          class="flex-col w-full lg:w-2/5 xl:w-1/3 gap-4"
        >
          <slot name="aside" />
        </aside>

        <!-- // details section -->
        <section class="w-full lg:w-3/5 xl:w-2/3 flex flex-col gap-4">
          <slot name="content" />
        </section>
      </div>
    </slot>
  </AuthenticatedLayout>
</template>
