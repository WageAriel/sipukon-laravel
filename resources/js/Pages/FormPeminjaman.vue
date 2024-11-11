<template>
    <HeaderNav/>
    <div class="max-w-lg mx-auto p-6">
      <h2 class="text-2xl font-bold text-center mb-6">Form Peminjaman</h2>
      
      <!-- Judul/ID Buku -->
      <div class="mb-4">
        <label for="bookId" class="block text-sm font-medium text-gray-700">Judul Buku *</label>
        <input
          type="text"
          id="bookId"
          v-model="form.judul"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
          placeholder="Text"
          required
        />
        <span v-if="errors.judul" class="text-red-500 text-sm">{{ errors.judul }}</span>
            </div>
      
      <!-- Nama Peminjam -->
      <div class="mb-4">
        <label for="borrowerName" class="block text-sm font-medium text-gray-700">Nama Peminjam *</label>
        <input
          type="text"
          id="borrowerName"
          v-model="form.nama_peminjam"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
          placeholder="Text"
          required
        />
        <span v-if="errors.judul" class="text-red-500 text-sm">{{ errors.nama_peminjam }}</span>
      </div>
      
      <!-- Tanggal Peminjaman & Tanggal Pengembalian -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Peminjaman *</label>
          <!-- Replace this with your chosen date picker component -->
          <input
            type="date"
            v-model="form.tanggal_peminjaman"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
            required
          />
          <span v-if="errors.judul" class="text-red-500 text-sm">{{ errors.tanggal_peminjaman }}</span>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Tanggal Pengembalian *</label>
          <!-- Replace this with your chosen date picker component -->
          <input
            type="date"
            v-model="form.tanggal_pengembalian"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
            required
          />
          <span v-if="errors.judul" class="text-red-500 text-sm">{{ errors.tanggal_pengembalian }}</span>
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
              v-model="form.metode_pengambilan"
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
              v-model="form.metode_pengambilan"
              class="focus:ring-sky-500 h-4 w-4 text-sky-600 border-gray-300"
              required
            />
            <label for="delivery" class="ml-3 block text-sm text-gray-700">Kirim ke alamat</label>
          </div>
          <span v-if="errors.judul" class="text-red-500 text-sm">{{ errors.metode_pengambilan }}</span>
        </div>
      </div>
  
      <!-- Alamat Pengiriman -->
      <div v-if="form.metode_pengambilan === 'delivery'" class="mt-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Pengiriman (Jika memilih pengiriman)</label>
        <textarea
          id="address"
          v-model="form.alamat"
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
  import { ref } from 'vue';
import axios from 'axios';

const form = ref({
  judul: '',
  nama_peminjam: '',
  tanggal_peminjaman: '',
  tanggal_pengembalian: '',
  metode_pengambilan: '',
  alamat: '',
});

const errors = ref({});

const handleSubmit = async () => {
    console.log('Form submitted');
    errors.value = {};

    // Validasi manual sebelum mengirim data
    if (!form.value.judul) {
        errors.value.judul = "Judul buku harus diisi.";
    }
    if (!form.value.nama_peminjam) {
        errors.value.nama_peminjam = "Nama peminjam harus diisi.";
    }
    // Cek validasi lainnya sesuai kebutuhan...

    // Jika ada kesalahan, jangan lanjutkan
    if (Object.keys(errors.value).length > 0) {
        return; // Kembali jika ada kesalahan
    } // Tambahkan ini untuk memeriksa jika fungsi dipanggil
    try {
        const response = await axios.post('/lending', {
            judul: form.value.judul,
            nama_peminjam: form.value.nama_peminjam,
            tanggal_peminjaman: form.value.tanggal_peminjaman,
            tanggal_pengembalian: form.value.tanggal_pengembalian,
            metode_pengambilan: form.value.metode_pengambilan,
            alamat: form.value.alamat,
        });
        console.log(response.data);
        errors.value = {}; // Reset error jika berhasil
    } catch (error) {
      if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors; // Mengambil error dari response
        } else if (error.response && error.response.data.message) {
            // Misalkan server mengembalikan pesan tidak ditemukan
            errors.value.judul = error.response.data.message; // Atur pesan tidak ditemukan ke errors.judul
        } else {
            console.error(error);
        }
    }
};

  </script>
  
  <style scoped>
  /* Add any custom styles here */
  </style>
  