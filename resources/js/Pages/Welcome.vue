<script setup>
import { Head } from "@inertiajs/vue3";
import Link from "@/Components/Link.vue";
import Logo from "@/Layouts/Partials/Logo.vue";
import Icon from "@/Components/Icon.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<template>
  <Head title="Welcome" />

  <div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
  >
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
      <Link v-if="$page.props.auth.user" label="Dashboard" :href="route('dashboard')" />

      <template v-else>
        <div class="space-x-4">
          <Link label="Log in" :href="route('login')" />

          <Link v-if="canRegister" label="Register" :href="route('register')" />
        </div>
      </template>
    </div>

    <div class="container mx-auto p-6 lg:p-8">
      <div class="flex justify-center">
        <Logo class="h-16 w-auto text-red-500" />
      </div>

      <div class="mt-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
          <a
            href="https://laravel.com/docs"
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
          >
            <div>
              <div
                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"
              >
                <Icon name="book" class="text-3xl text-red-500" />
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                Documentation
              </h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Laravel has wonderful documentation covering every aspect of the
                framework. Whether you are a newcomer or have prior experience with
                Laravel, we recommend reading our documentation from beginning to end.
              </p>
            </div>

            <Icon name="arrow-right" class="self-center text-2xl text-red-500 mx-4" />
          </a>

          <a
            href="https://laracasts.com"
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
          >
            <div>
              <div
                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"
              >
                <Icon name="camera-reels" class="text-3xl text-red-500" />
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                Laracasts
              </h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Laracasts offers thousands of video tutorials on Laravel, PHP, and
                JavaScript development. Check them out, see for yourself, and massively
                level up your development skills in the process.
              </p>
            </div>

            <Icon name="arrow-right" class="self-center text-2xl text-red-500 mx-4" />
          </a>

          <a
            href="https://laravel-news.com"
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
          >
            <div>
              <div
                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"
              >
                <Icon name="newspaper" class="text-3xl text-red-500" />
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                Laravel News
              </h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Laravel News is a community driven portal and newsletter aggregating all
                of the latest and most important news in the Laravel ecosystem, including
                new package releases and tutorials.
              </p>
            </div>

            <Icon name="arrow-right" class="self-center text-2xl text-red-500 mx-4" />
          </a>

          <div
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
          >
            <div>
              <div
                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"
              >
                <Icon name="vinyl" class="text-3xl text-red-500" />
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                Vibrant Ecosystem
              </h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Laravel's robust library of first-party tools and libraries, such as
                <a
                  href="https://forge.laravel.com"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Forge</a
                >,
                <a
                  href="https://vapor.laravel.com"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Vapor</a
                >,
                <a
                  href="https://nova.laravel.com"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Nova</a
                >, and
                <a
                  href="https://envoyer.io"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Envoyer</a
                >
                help you take your projects to the next level. Pair them with powerful
                open source libraries like
                <a
                  href="https://laravel.com/docs/billing"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Cashier</a
                >,
                <a
                  href="https://laravel.com/docs/dusk"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Dusk</a
                >,
                <a
                  href="https://laravel.com/docs/broadcasting"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Echo</a
                >,
                <a
                  href="https://laravel.com/docs/horizon"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Horizon</a
                >,
                <a
                  href="https://laravel.com/docs/sanctum"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Sanctum</a
                >,
                <a
                  href="https://laravel.com/docs/telescope"
                  class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >Telescope</a
                >, and more.
              </p>
            </div>

            <Icon name="arrow-right" class="self-center text-2xl text-red-500 mx-4" />
          </div>
        </div>
      </div>

      <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
        <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
          <div class="flex items-center gap-4">
            <a
              href="https://github.com/sponsors/taylorotwell"
              class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >
              <Icon
                name="heart"
                class="-mt-px mr-2 text-gray-400 dark:text-gray-600 group-hover:text-gray-600 dark:group-hover:text-gray-400"
              />

              Sponsor
            </a>
          </div>
        </div>

        <div
          class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0"
        >
          Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
