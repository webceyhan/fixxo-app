<template>
  <nav class="navbar">
    <slot>
      <!-- start -->
      <div class="navbar-start">
        <slot name="start" />
      </div>

      <!-- center -->
      <div  class="navbar-center">
        <slot name="center" />
      </div>

      <!-- end -->
      <div class="navbar-end">
        <slot name="end" />
      </div>
    </slot>
  </nav>
</template>
