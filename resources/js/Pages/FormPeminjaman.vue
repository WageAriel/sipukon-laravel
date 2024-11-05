<template>
    <HeaderNav/>
    <div class="max-w-lg mx-auto p-6">
      <h2 class="text-2xl font-bold text-center mb-6">Form Peminjaman</h2>
      
      <!-- Judul/ID Buku -->
      <div class="mb-4">
        <label for="bookId" class="block text-sm font-medium text-gray-700">Judul/ID Buku *</label>
        <input
          type="text"
          id="bookId"
          v-model="form.bookId"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
          placeholder="Text"
          required
        />
      </div>
      
      <!-- Nama Peminjam -->
      <div class="mb-4">
        <label for="borrowerName" class="block text-sm font-medium text-gray-700">Nama Peminjam *</label>
        <input
          type="text"
          id="borrowerName"
          v-model="form.borrowerName"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
          placeholder="Text"
          required
        />
      </div>
      
      <!-- Tanggal Peminjaman & Tanggal Pengembalian -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Peminjaman *</label>
          <!-- Replace this with your chosen date picker component -->
          <input
            type="date"
            v-model="form.borrowDate"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Pengembalian *</label>
          <!-- Replace this with your chosen date picker component -->
          <input
            type="date"
            v-model="form.returnDate"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
            required
          />
        </div>
      </div>
  
      <!-- Metode Pengambilan Buku -->
      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Metode Pengambilan Buku *</label>
        <div class="mt-2 space-y-2">
          <div class="flex items-center">
            <input
              type="radio"
              id="pickup"
              value="pickup"
              v-model="form.pickupMethod"
              class="focus:ring-sky-500 h-4 w-4 text-sky-600 border-gray-300"
              required
            />
            <label for="pickup" class="ml-3 block text-sm text-gray-700">Ambil di perpustakaan</label>
          </div>
          <div class="flex items-center">
            <input
              type="radio"
              id="delivery"
              value="delivery"
              v-model="form.pickupMethod"
              class="focus:ring-sky-500 h-4 w-4 text-sky-600 border-gray-300"
              required
            />
            <label for="delivery" class="ml-3 block text-sm text-gray-700">Kirim ke alamat</label>
          </div>
        </div>
      </div>
  
      <!-- Alamat Pengiriman -->
      <div v-if="form.pickupMethod === 'delivery'" class="mt-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Pengiriman (Jika memilih pengiriman)</label>
        <textarea
          id="address"
          v-model="form.address"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
          placeholder="Text"
        ></textarea>
      </div>
  
      <!-- Submit Button -->
      <div class="mt-6">
        <button
          type="submit"
          @click.prevent="handleSubmit"
          class="w-full bg-sky-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
        >
          Submit
        </button>
      </div>
    </div>
    <FooterView/>
  </template>
  
  <script setup>
  import HeaderNav from '@/ComponentLanding/HeaderNav.vue'
  import FooterView from '@/ComponentLanding/FooterView.vue'
  </script>

  <script>
  export default {
    data() {
      return {
        form: {
          bookId: '',
          borrowerName: '',
          borrowDate: '',
          returnDate: '',
          pickupMethod: '',
          address: '',
        },
      };
    },
    methods: {
      handleSubmit() {
        // Handle form submission
        console.log(this.form);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any custom styles here */
  </style>
  