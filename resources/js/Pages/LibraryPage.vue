<template>
  <HeaderNav />
  <div class="flex overflow-hidden relative flex-col bg-white">
    <div class="flex z-0 mt-14 w-full bg-sky-500 min-h-[197px] max-md:mt-10 max-md:max-w-full relative">
      <!-- Centered Search Bar -->
      <form class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center bg-white rounded-full px-5 py-2 shadow-md max-md:w-full max-md:px-3">
        <label for="search" class="sr-only">Search</label>
        <input type="search" id="search" class="w-64 max-md:w-full outline-none" aria-label="Search" placeholder="Search for books..." />
        <button type="submit" aria-label="Search" class="ml-2">
          <MagnifyingGlassIcon class="w-5 h-5" />
        </button>
        <button type="button" aria-label="Settings" class="ml-2">
          <AdjustmentsHorizontalIcon alt="Settings Icon" class="w-5 h-5" />
        </button>
      </form>
    </div>

    <main class="flex z-0 flex-col self-center mt-14 max-w-full w-[1272px] max-md:mt-10">
      <section class="grid-container">
        <BookCard v-for="item in data" :key="item.id" :data="item" />
      </section>
    </main>
  </div>
  <FooterView />
</template>

<script setup>
import HeaderNav from '@/ComponentLanding/HeaderNav.vue';
import FooterView from '@/ComponentLanding/FooterView.vue';
import { MagnifyingGlassIcon, AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid';
import BookCard from './BookCard.vue';

// Mendefinisikan props
defineProps({
  data: {
    type: Array,
    required: true,
  },
});
</script>

<style>
/* Mengatur grid layout */
.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* 4 kolom maksimum, responsif */
  gap: 1rem; /* Jarak antar item */
}

@media (max-width: 768px) {
  .grid-container {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Kolom lebih kecil untuk layar kecil */
  }
}
</style>
