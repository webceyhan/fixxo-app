<script setup>
import { computed } from "vue";
import { formatDate, formatMoney } from "@/Shared/utils";
import Logo from "@/Layouts/Partials/Logo.vue";

const props = defineProps({
  asset: Object,
  tasks: Array,
  payments: Array,
  delivery: Boolean,
});

const signatureUrl = computed(() => {
  return props.delivery
    ? props.asset.delivery_signature_url
    : props.asset.intake_signature_url;
});
</script>

<template>
  <div class="space-y-6 p-10">
    <header class="flex justify-between items-end">
      <!-- left -->

      <div class="space-y-4">
        <!-- title -->
        <h1 class="text-5xl font-light capitalize">
          {{ delivery ? "delivery receipt" : "intake receipt" }}
        </h1>

        <!-- timestamp -->
        <p class="text-sm">
          Created on <strong>{{ formatDate(asset.created_at) }}</strong> by
          <strong>{{ asset.user.name }}</strong>
        </p>
      </div>

      <!-- right / company info -->
      <div class="text-xs text-right space-y-1">
        <Logo class="inline-block w-10" />

        <h2 class="text-xl">Acme Inc.</h2>

        <address>
          <p>Manhatten Lane 345 - 1040 New York</p>
          <p>
            <span> phone: 01/219 59 26 </span>-
            <span> fax: 01/223 44 54 </span>
          </p>
        </address>

        <div>
          <p class="font-bold">opening hours of technical service</p>
          <p>monday to saturday from 10:00 to 19:00</p>
        </div>
      </div>
    </header>

    <br />
    <br />

    <section class="relative space-y-6">
      <!-- qr code -->
      <img :src="asset.qr_url" class="w-28 h-auto absolute right-0" />

      <!-- asset info -->
      <div>
        <h1 class="text-lg font-semibold">Asset</h1>
        <p>{{ asset.brand }} {{ asset.name }}</p>
      </div>

      <!-- customer info -->
      <div class="space-y-1">
        <h2 class="text-lg font-semibold">Customer</h2>
        <p class="capitalize">{{ asset.customer.name }}</p>
      </div>

      <!-- problem -->
      <div>
        <h1 class="text-lg font-semibold">Problem</h1>
        <p>{{ asset.problem }}</p>
      </div>
    </section>

    <br />
    <br />
  </div>

  <footer class="fixed bottom-0 inset-x-0 space-y-6 p-10">
    <hr />

    <!-- terms and conditions -->
    <p class="text-justify text-xs">
      These Website Standard Terms and Conditions written on this webpage shall manage
      your use of our website, Webiste Name accessible at Website.com. These Terms will be
      applied fully and affect to your use of this Website. By using this Website, you
      agreed to accept all terms and conditions written in here. You must not use this
      Website if you disagree with any of these Website Standard Terms and Conditions.
      Minors or people below 18 years old are not allowed to use this Website.
    </p>

    <!-- signature section -->
    <section class="flex">
      Signature of agreement on the terms of Acme Inc. guarantees by the customer :

      <img v-if="signatureUrl" :src="signatureUrl" class="w-40 h-auto" />
    </section>
  </footer>
</template>
