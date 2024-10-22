<script setup lang="ts">
import Toolbar from "@/Components/Toolbar.vue";
import BackButton from "@/Components/Button/BackButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps<{
  title: string;
  contentOnlyMobile?: boolean;
}>();
</script>

<template>
  <AuthenticatedLayout :title>
    <Toolbar>
      <BackButton class="mr-auto" />

      <slot name="toolbar">
        <!-- desktop -->
        <div class="hidden lg:flex gap-2">
          <slot name="desktop-menu" />
        </div>

        <!-- mobile -->
        <div class="lg:hidden">
          <slot name="mobile-menu" />
        </div>
      </slot>
    </Toolbar>

    <slot>
      <div class="flex flex-col lg:flex-row items-start gap-6 lg:gap-8">
        <!-- // aside -->
        <aside
          :class="[
            'flex-col w-full lg:w-2/5 xl:w-1/3 gap-6 lg:gap-8',
            contentOnlyMobile ? 'hidden sm:flex' : 'flex',
          ]"
        >
          <slot name="aside" />
        </aside>

        <!-- // details section -->
        <section class="w-full lg:w-3/5 xl:w-2/3 flex flex-col gap-6 lg:gap-8">
          <slot name="content" />
        </section>
      </div>
    </slot>
  </AuthenticatedLayout>
</template>
