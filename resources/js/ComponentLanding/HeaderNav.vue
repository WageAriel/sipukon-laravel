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

          
      <!-- User Avatar and Login/Logout Buttons -->
      <div class="hidden md:flex gap-4 my-auto text-sm font-extrabold text-center text-white items-center">
          <!-- Button with UserCircleIcon only if user is logged in -->
          <div class="relative" v-if="auth.user">
              <!-- Button with UserCircleIcon -->
              <button @click="showProfile = true" class="flex items-center justify-center object-contain shrink-0 rounded-3xl aspect-square w-16 ">
                  <UserCircleIcon class="w-12 h-12 text-sky-500" />
              </button>

              <!-- Profile component displayed as modal -->
              <Profile v-if="showProfile" @close="showProfile = false" />
          </div>

          <Link v-if="!auth.user" :href="route('login')" class="overflow-hidden border-2 gap-2.5 px-6 py-3 bg-sky-500 hover:bg-white hover:text-sky-500 hover:border-solid hover:border-2 hover:border-sky-500 rounded-xl">
              Login
          </Link>
          <button v-else @click="logout" class="overflow-hidden gap-2.5 px-6 py-3 bg-red-500 rounded-xl">
              Logout
          </button>
      </div>

      <!-- Mobile Menu Button -->
      <button @click="toggleSidebar" class="flex md:hidden text-gray-500 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
      </button>

      <!-- Sidebar Overlay -->
      <div v-if="isSidebarOpen" class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="toggleSidebar"></div>

      <!-- Sidebar Menu -->
      <aside v-if="isSidebarOpen" class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg z-50 transform transition-transform translate-x-0 md:hidden">
          <div class="flex justify-end p-4">
              <button @click="toggleSidebar" class="text-gray-600 focus:outline-none">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
              </button>
          </div>
          <nav class="flex flex-col gap-4 px-8 text-base font-medium capitalize text-neutral-900">
              <Link href="/" @click="toggleSidebar" class="py-2">HOME</Link>
              <Link href="/library" @click="toggleSidebar" class="py-2">LIBRARY</Link>
              <Link href="/lending" @click="toggleSidebar" class="py-2">LENDING</Link>
              <Link href="/about" @click="toggleSidebar" class="py-2">ABOUT</Link>
          </nav>
          <div class="flex flex-col items-center gap-4 mt-4 px-8">
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/d32ba014fd2f43b69edb017a43e6b422/70ae46c9b276bc3e2a70e0880c2c18f82ac4e26f8512fa945770e15590e71200?apiKey=d32ba014fd2f43b69edb017a43e6b422&" alt="User avatar" class="object-contain shrink-0 rounded-3xl aspect-square w-16" />
              <Link v-if="!auth.user" :href="route('login')" class="overflow-hidden px-6 py-3 bg-sky-500 text-white rounded-xl w-full text-center" @click="toggleSidebar">
                  Login
              </Link>
              <button v-else @click="logout" class="overflow-hidden px-6 py-3 bg-red-500 text-white rounded-xl w-full">
                  Logout
              </button>
          </div>
      </aside>
  </header>
</template>

<script>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { UserCircleIcon } from '@heroicons/vue/24/solid';
import Profile from '@/Pages/ProfilView.vue'

export default {
  name: 'NavigationBar',
  components: {
      Link,
      UserCircleIcon,
      Profile
  },
  data() {
      return {
          showProfile: false, // Mengontrol apakah Profile.vue ditampilkan atau tidak
      };
  },
  setup() {
      const isSidebarOpen = ref(false)
      const { auth } = usePage().props

      const toggleSidebar = () => {
          isSidebarOpen.value = !isSidebarOpen.value
      }

      const logout = () => {
          auth.user = null; // Kosongkan auth.user secara lokal
          Inertia.post(route('logout'), {
              onSuccess: () => {
                  Inertia.reload({
                      only: ['auth']
                  }); // Pastikan auth terbaru
              }
          });
      };

      return {
          auth,
          isSidebarOpen,
          toggleSidebar,
          logout,
      }
  }
}
</script>

<style scoped>
/* Tambahkan styling tambahan di sini jika diperlukan */
</style>
