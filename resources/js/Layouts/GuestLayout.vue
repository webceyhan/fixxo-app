<script setup>
import { Link } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Logo from "./Partials/Logo.vue";
</script>

<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
      <Link href="/">
        <Logo class="w-20 h-20 fill-current" />
      </Link>
    </div>

    <Card class="w-full sm:max-w-md mt-6">
      <slot />
    </Card>
  </div>
</template>
