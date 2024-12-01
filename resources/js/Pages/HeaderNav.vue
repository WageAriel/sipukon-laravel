<template>
  <header class="flex overflow-hidden flex-wrap gap-10 px-9 py-3.5 whitespace-nowrap bg-white bg-opacity-0 max-md:px-5 justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center">
          <img loading="lazy" src="../image/logo-uns-besar-biru 1.png" alt="Company logo" class="object-contain shrink-0 self-stretch max-w-full aspect-[2.11] w-[150px] md:w-[207px]" />
      </div>

      <!-- Desktop Navigation Links -->
      <nav class="hidden md:flex gap-10 items-center text-base font-medium capitalize text-neutral-900">
          <Link href="/" class="self-stretch my-auto hover:text-sky-500">HOME</Link>
          <Link href="/library" class="self-stretch my-auto hover:text-sky-500">LIBRARY</Link>
          <Link href="/lending" class="self-stretch my-auto hover:text-sky-500">LENDING</Link>
          <Link href="/about" class="self-stretch my-auto hover:text-sky-500">ABOUT</Link>
      </nav>

          
      <div class="hidden md:flex gap-4 my-auto text-sm font-extrabold text-center text-white items-center">
          <div class="relative" v-if="auth.user">
              <button @click="showProfile = true" class="flex items-center justify-center object-contain shrink-0 rounded-3xl aspect-square w-16 ">
                  <UserCircleIcon class="w-12 h-12 text-sky-500" />
              </button>
              <Profile v-if="showProfile" @close="showProfile = false" />
          </div>

          <Link v-if="!auth.user" :href="route('login')" class="overflow-hidden border-2 gap-2.5 px-6 py-3 bg-sky-500 hover:bg-white hover:text-sky-500 hover:border-solid hover:border-2 hover:border-sky-500 rounded-xl">
              Login
          </Link>
          <button v-else @click="logout" class="overflow-hidden gap-2.5 px-6 py-3 bg-red-500 rounded-xl">
              Logout
          </button>
      </div>
  </header>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { UserCircleIcon } from '@heroicons/vue/24/solid';
import Profile from '@/Pages/ProfilView.vue';

// Mendeklarasikan state dengan ref
const isSidebarOpen = ref(false);
const { auth } = usePage().props;
const showProfile = ref(false); // Mengontrol apakah Profile.vue ditampilkan atau tidak

// Fungsi untuk toggle sidebar
const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

// Fungsi untuk logout
const logout = () => {
    auth.user = null; // Kosongkan auth.user secara lokal
    Inertia.post(route('logout'), {
        onSuccess: () => {
            Inertia.reload({
                only: ['auth'],
            }); // Pastikan auth terbaru
        },
    });
};
</script>


<style scoped>
/* Tambahkan styling tambahan di sini jika diperlukan */
</style>
