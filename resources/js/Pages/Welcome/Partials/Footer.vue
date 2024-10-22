<template>
    <footer class="footer footer-center bg-base-300 mt-20 py-8">
      <aside>
          <slot />
        <p class="footer-title">
        
          Copyright © {{ new Date().getFullYear() }} - All right reserved by ACME Industries
          Ltd
        </p>
      </aside>
    </footer>
  </template>
  