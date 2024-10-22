<script setup>
import MenuLink from "@/Components/Menu/MenuLink.vue";

defineProps({
  active: Boolean,
});
</script>

<template>
  <MenuLink
    :class="[
      'px-6 py-3 gap-3',
      'text-base-content/70 text-[16px] font-bold',
      'rounded-none border-l-2 border-transparent hover:border-current',
      {
        '!text-base-content bg-neutral/20 border-inherit': active,
      },
    ]"
  />
</template>

<style scoped>
:deep(.icon) {
  font-size: 20px;
  line-height: 28px;
}
</style>
