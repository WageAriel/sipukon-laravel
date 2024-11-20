<template>
  <article
    class="flex flex-col w-full max-w-sm mx-auto bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
    @click="openModal"
  >
    <div class="relative rounded-t-lg overflow-hidden bg-gray-100">
      <img
        :src="`/storage/book_covers/${data.cover_image}`"
        alt="Book Cover"
        class="w-full h-64 object-contain"
      />
    </div>
    <div class="p-4 flex flex-col">
      <h3 class="text-xl font-semibold text-gray-800">{{ data.title }}</h3>
      <p class="text-sm text-gray-600 mt-1">Author: {{ data.author }}</p>
    </div>

    <!-- Pop-up Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <!-- Card Title -->
        <h3 class="text-xl font-semibold text-gray-800">{{ data.title }}</h3>
        <!-- Card Details -->
        <p class="text-sm text-gray-600 mt-1">Author: {{ data.author }}</p>
        <p class="text-sm text-gray-600">ISBN: {{ data.isbn }}</p>
        <p class="text-sm text-gray-600">Publisher: {{ data.publisher }}</p>
        <p class="text-sm text-gray-600">Year: {{ data.tahun }}</p>
        <div class="flex justify-end space-x-4 mt-4">
          <!-- Button Pinjam -->
          <button
            @click.stop="redirectToForm(data.title)"
            class="bg-sky-500 text-white px-4 py-2 rounded-md hover:bg-sky-600"
          >
            Pinjam
          </button>

          <!-- Button Kembali -->
          <button
            @click.stop="closeModal"
            class="bg-gray-300 px-4 py-2 rounded-md hover:bg-gray-400"
          >
            Kembali
          </button>
        </div>
      </div>
    </div>
  </article>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { Inertia } from "@inertiajs/inertia";

// Props
defineProps({
  data: {
    type: Object,
    required: true,
  },
});



const router = useRouter();
// Reactive state
const showModal = ref(false);

// Router instance
// const router = useRouter();  

// Open modal function
const openModal = () => {
  showModal.value = true;
};

// Close modal function
const closeModal = () => {
  showModal.value = false; // Tutup modal
};

// Redirect to lending form
const redirectToForm = (title) => {
    showModal.value = false; // Tutup modal jika dibuka
    Inertia.visit('/lending', { data: { judul: title } });
};
</script>
