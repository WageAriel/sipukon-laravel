<template>
    <HeaderNav/>
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
        <section class="max-md:max-w-full">
          <div class="flex gap-5 max-md:flex-col">
            <BookCard v-for="n in 4" :key="n" />
          </div>
        </section>
        <section class="mt-9 max-md:max-w-full">
          <div class="flex gap-5 max-md:flex-col">
            <BookCard v-for="n in 4" :key="n + 4" />
          </div>
        </section>
      </main>
    </div>
    <FooterView/>
  </template>
  
  <script setup>
  import HeaderNav from '@/ComponentLanding/HeaderNav.vue'
  import FooterView from '@/ComponentLanding/FooterView.vue'
  import { MagnifyingGlassIcon, AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid';
  </script>

  <script>
  import BookCard from './BookCard.vue';
  
  export default {
    name: 'LibraryPage',
    components: {
      BookCard,
    },
  };
  </script>
  