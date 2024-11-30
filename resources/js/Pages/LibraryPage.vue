<template>
  <HeaderNav />
  <div class="flex overflow-hidden relative flex-col bg-white">
    <div class="flex z-0 mt-14 w-full bg-sky-500 min-h-[197px] max-md:mt-10 max-md:max-w-full relative">
      <!-- Centered Search Bar -->
      <form
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center bg-white rounded-full px-5 py-2 shadow-md max-md:w-full max-md:px-3"
        @submit.prevent="handleSearch"
      >
        <label for="search" class="sr-only">Search</label>
        <input
          type="search"
          id="search"
          class="w-64 max-md:w-full outline-none border-none"
          aria-label="Search"
          placeholder="Search for books..."
          v-model="searchQuery"
        />
        <button type="submit" aria-label="Search" class="ml-2">
          <MagnifyingGlassIcon class="w-5 h-5" />
        </button>
      </form>
    </div>

    <main class="flex z-0 flex-col self-center mt-14 max-w-full w-[1272px] max-md:mt-10">
      <section class="grid-container">
        <!-- Gunakan filteredBooks -->
        <BookCard v-for="item in filteredBooks" :key="item.id" :data="item" />
      </section>
    </main>
  </div>
  <FooterView />
</template>

<script setup>
import { ref, computed } from 'vue';
import HeaderNav from '@/Pages/HeaderNav.vue';
import FooterView from '@/ComponentLanding/FooterView.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import BookCard from './BookCard.vue';

// Mendefinisikan props
const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
});

const searchQuery = ref('');
const books = props.data; // Gunakan props untuk mendefinisikan data

// Computed untuk menyaring buku berdasarkan pencarian
const filteredBooks = computed(() => {
  if (!searchQuery.value.trim()) {
    return books; // Jika pencarian kosong, tampilkan semua buku
  }
  // Filter berdasarkan judul atau author
  return books.filter((book) =>
    book.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    book.author.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const handleSearch = () => {
  console.log(`Searching for: ${searchQuery.value}`);
};
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
