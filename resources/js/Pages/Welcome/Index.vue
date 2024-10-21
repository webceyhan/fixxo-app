<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Logo from "@/Layouts/Partials/Logo.vue";
import Link from "@/Components/Link.vue";
import Icon from "@/Components/Icon.vue";
import FeatureCard from "./Partials/FeatureCard.vue";
import FeatureLink from "./Partials/FeatureLink.vue";
import Footer from "./Partials/Footer.vue";

defineProps<{
  canLogin?: boolean;
  canRegister?: boolean;
  laravelVersion: string;
  phpVersion: string;
}>();
</script>

<template>
  <Head title="Welcome" />
  <div>
    <img
      class="absolute -left-20 top-0 max-w-[877px]"
      src="https://laravel.com/assets/img/welcome/background.svg"
    />
    <div class="relative min-h-screen flex flex-col items-center justify-center">
      <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
        <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
          <div class="flex lg:justify-center lg:col-start-2">
            <Logo class="lg:size-20" />
          </div>
          <nav
            v-if="canLogin"
            class="-mx-3 flex flex-1 justify-end gap-4 mr-2 text-base-content"
          >
            <Link
              v-if="$page.props.auth.user"
              :href="route('dashboard')"
              label="Dashboard"
            />

            <template v-else>
              <Link :href="route('login')" label="Log in" />

              <Link v-if="canRegister" :href="route('register')" label="Register" />
            </template>
          </nav>
        </header>

        <main class="mt-6">
          <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
            <!-- documentation -->
            <FeatureCard href="https://laravel.com/docs" class="md:row-span-3">
              <template #top>
                <img
                  src="https://laravel.com/assets/img/welcome/docs-dark.svg"
                  alt="Laravel documentation screenshot"
                  class="aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.25)]"
                />
              </template>

              <template #avatar>
                <Icon name="book" />
              </template>

              <template #title> Documentation </template>

              Laravel has wonderful documentation covering every aspect of the framework.
              Whether you are a newcomer or have prior experience with Laravel, we
              recommend reading our documentation from beginning to end.
            </FeatureCard>

            <!-- laracast -->
            <FeatureCard href="https://laracasts.com">
              <template #avatar>
                <Icon name="youtube" />
              </template>

              <template #title> Laracasts </template>

              Laracasts offers thousands of video tutorials on Laravel, PHP, and
              JavaScript development. Check them out, see for yourself, and massively
              level up your development skills in the process.
            </FeatureCard>

            <!-- laravel news -->
            <FeatureCard href="https://laravel-news.com">
              <template #avatar>
                <Icon name="newspaper" />
              </template>

              <template #title> Laravel News </template>

              Laravel News is a community driven portal and newsletter aggregating all of
              the latest and most important news in the Laravel ecosystem, including new
              package releases and tutorials.
            </FeatureCard>

            <!-- vibrant ecosystem -->
            <FeatureCard inline>
              <template #avatar>
                <Icon name="globe" />
              </template>

              <template #title> Vibrant Ecosystem </template>

              Laravel's robust library of first-party tools and libraries, such as
              <FeatureLink href="https://forge.laravel.com" label="Forge" />,
              <FeatureLink href="https://vapor.laravel.com" label="Vapor" />,
              <FeatureLink href="https://nova.laravel.com" label="Nova" />,
              <FeatureLink href="https://envoyer.io" label="Envoyer" />, and
              <FeatureLink href="https://herd.laravel.com" label="Herd" />
              help you take your projects to the next level. Pair them with powerful open
              source libraries like
              <FeatureLink href="https://laravel.com/docs/billing" label="Cashier" />,
              <FeatureLink href="https://laravel.com/docs/dusk" label="Dusk" />,
              <FeatureLink href="https://laravel.com/docs/broadcasting" label="Echo" />,
              <FeatureLink href="https://laravel.com/docs/horizon" label="Horizon" />,
              <FeatureLink href="https://laravel.com/docs/sanctum" label="Sanctum" />,
              <FeatureLink href="https://laravel.com/docs/telescope" label="Telescope" />,
              and more.
            </FeatureCard>
          </div>
        </main>
      </div>
    </div>

    <Footer> Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }}) </Footer>
  </div>
</template>
