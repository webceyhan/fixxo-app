<template>
  <div class="input-group">
    <slot />
  </div>
</template>

<style>
.input-group {
  position: relative;
  /* display: flex; */
  /* flex-wrap: wrap; */
  /* align-items: stretch; */
  width: 100%;
}

/* .input-group > * {
  position: relative;
  flex: 1 1 auto;
  width: 1%;
  min-width: 0;
} */

.input-group > :not(:first-child) {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}

.input-group > :not(:last-child) {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}
</style>
