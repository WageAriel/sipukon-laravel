<template>
  <Head title="Landing" />
  <HeaderNav/>
  <div class="flex justify-center mt-[-60px] items-center min-h-screen">
    <div class="w-full max-w-[1233px] h-auto md:h-[655px] mx-auto flex flex-col md:flex-row justify-start items-center">
        <div class="w-full max-w-[530px] flex flex-col justify-start items-start gap-[43px] p-4 md:p-0">
            <div class="px-8 py-4 bg-white rounded-full shadow justify-start items-center gap-4 inline-flex">
                <div class="w-[247px] text-[#00afef] text-xl font-normal leading-normal">Explore UNS Online Library!</div>
                <BuildingLibraryIcon class="w-6 h-6 relative text-[#00afef]"/>
            </div>
            <div class="w-full max-w-[474px] text-center md:text-left">
                <span class="text-black text-[40px] md:text-[69px] font-bold leading-[82.80px]">Discover </span>
                <span class="text-[#00afef] text-[40px] md:text-[69px] font-bold leading-[82.80px]">the World</span>
                <span class="text-black text-[40px] md:text-[69px] font-bold leading-[82.80px]"> of Knowledge</span>
            </div>
            <div class="text-[#191825]/50 text-lg md:text-xl font-normal font-['Inter'] leading-loose text-center md:text-left">Bringing a Universe of Books Right to Your Fingertips</div>
            <div class="flex justify-center md:justify-start items-start gap-4">
                <button class="px-8 py-4 bg-[#00afef] rounded-full shadow flex justify-center items-center">
                    <Link href="/library" class="text-[#eeeeee] text-base font-bold leading-tight">Start Reading!</Link>
                </button>
            </div>
        </div>
        <div class="w-full max-w-[772px] h-auto md:h-[655px] relative flex justify-center items-center">
            <div class="hidden md:block w-[772px] h-[182px] absolute top-0"></div>
            <div class="flex flex-wrap justify-center items-center gap-[31px]">
                <div class="flex flex-col justify-start items-start gap-8">
                    <img class="w-[272px] h-[300px] rounded-[32px]" src="@/image/Rak buku.png" />
                    <img class="w-[272px] h-[300px] rounded-[32px]" src="@/image/Gerdep.png" />
                </div>
                <img class="w-[267px] h-[400px] rounded-[35px]" src="@/image/Perpus.png" />
            </div>
            <div class="hidden md:block h-16 p-4 absolute left-[56px] top-[289px] bg-[#00afef] rounded-full shadow inline-flex items-center gap-2">
                <PaperAirplaneIcon class="w-8 h-8 text-white -rotate-45"/>
            </div>
            <div class="hidden md:flex h-14 px-4 py-4 absolute left-[550px] top-[436px] bg-white rounded-full shadow items-center gap-2">
                <MapPinIcon class="w-8 h-8 text-yellow-400"/>
                <div class="text-[#393e46] text-sm font-bold">Top Places</div>
            </div>
        </div>
    </div>
</div>



<div class="h-auto md:h-[546px] flex flex-col md:flex-row justify-center items-center mt-[80px] gap-8 md:gap-10 px-4 py-8">
    <!-- Section Title -->
    <div class="w-full md:w-[444px] flex flex-col justify-start items-start gap-4 text-center md:text-left">
        <div class="text-[#00afef] text-[20px] md:text-[23px] font-bold uppercase leading-7 tracking-[4.60px]">
            Fitur
        </div>
        <div class="text-[#191825] text-[32px] md:text-[44px] font-bold leading-[1.2]">
            Fitur utama pada website ini
        </div>
    </div>

    <!-- Features Section -->
    <div class="flex flex-col md:flex-row justify-start items-center gap-6 md:gap-[21px]">
        <!-- Manajemen Peminjaman Card -->
        <div class="w-full md:w-[350px] p-8 md:p-16 bg-white rounded-[32px] flex flex-col justify-start items-center gap-8 shadow">
            <img class="w-12 h-12 md:w-16 md:h-16" src="@/image/peminjaman.png" alt="Manajemen Peminjaman" />
            <div class="flex flex-col items-center gap-4 text-center">
                <div class="text-[#191825] text-[24px] md:text-[28px] font-bold leading-[1.2]">
                    Manajemen Peminjaman
                </div>
                <div class="text-[#191825]/50 text-base md:text-lg font-normal font-['Inter'] leading-[1.6]">
                    Sistem yang memudahkan Anda untuk meminjam buku secara online dengan proses yang cepat dan praktis.
                </div>
            </div>
        </div>

        <!-- Pengiriman Buku Card -->
        <div class="w-full md:w-[350px] p-8 md:p-16 bg-white rounded-[32px] flex flex-col justify-start items-center gap-8 shadow">
            <img class="w-12 h-12 md:w-16 md:h-16" src="@/image/pengiriman.png" alt="Pengiriman Buku" />
            <div class="flex flex-col items-center gap-4 text-center">
                <div class="text-[#191825] text-[24px] md:text-[28px] font-bold leading-[1.2]">
                    Pengiriman Buku
                </div>
                <div class="text-[#191825]/50 text-base md:text-lg font-normal font-['Inter'] leading-[1.6]">
                    Kami akan mengirimkan buku ke alamat Anda dengan aman, memastikan buku tiba dalam kondisi terbaik tanpa penundaan.
                </div>
            </div>
        </div>
    </div>
</div>



<div class="w-[1440px] h-[228px] px-[165px] mt-[80px] py-16 justify-between items-center inline-flex">
    <div class="flex-col justify-start items-start gap-4 inline-flex">
        <div class="text-[#00afef] text-[23px] font-bold uppercase leading-7 tracking-[4.60px]">Rekomendasi</div>
        <div class="text-[#191825] text-[44px] font-bold leading-[52.80px]">Rekomendasi Buku</div>
    </div>
    <div class="justify-start items-start gap-8 flex">
        <button @click="showPrevious" class="w-[100px] h-[100px] relative">
            <div class="w-[100px] h-[100px] left-0 top-0 absolute bg-white rounded-[100px] border border-[#191825]/10"></div>
            <ArrowLeftIcon class="w-6 h-6 left-[38px] top-[38px] absolute"></ArrowLeftIcon>
        </button>
        <button @click="showNext" class="w-[100px] h-[100px] relative">
            <div class="w-[100px] h-[100px] left-[100px] top-0 absolute origin-left rotate-180 bg-[#00afef] rounded-[100px]"></div>
            <ArrowLeftIcon class="w-6 h-6 left-[62px] top-[38px] text-white absolute origin-left rotate-180"/>
        </button>
    </div>
</div>
<div class="w-full max-w-screen-lg mx-auto">
    
    <!-- Header Rekomendasi Buku -->

    <!-- Daftar Rekomendasi Buku -->
    <div class="flex justify-center gap-6 p-4">
      <div
        v-for="(book, index) in visibleBooks"
        :key="index"
        class="w-[350px] h-[575px] shadow-lg flex flex-col rounded-[32px] overflow-hidden border border-gray-300"
      >
        <div class="w-full h-[376px] bg-[#99dbf7]"></div>
        <div class="w-full h-[350px] px-8 pt-6 pb-4 bg-white flex flex-col gap-4 border-t border-gray-300">
          <div class="flex flex-col gap-2">
            <div class="text-[#191825] text-[23px] font-bold leading-7">
              {{ book.judul }}
            </div>
            <div class="text-[#191825]/75 text-lg font-normal leading-[28.80px] max-w-[300px]">
              {{ book.deskripsi }}
            </div>
          </div>
          <div class="flex items-center gap-2 mt-auto">
            <div class="text-[#ff5722] text-[23px] font-bold leading-7">
              {{ book.rating }}
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#ff5722]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
  <FooterView/>
</template>

<script setup>
import { ref, onBeforeMount, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { BuildingLibraryIcon, PaperAirplaneIcon, MapPinIcon, ArrowLeftIcon } from '@heroicons/vue/24/solid';
import HeaderNav from '@/Pages/HeaderNav.vue'
import FooterView from '@/ComponentLanding/FooterView.vue'

const logout = async () => {
  try {
    await router.post(route("logout"), {
      onSuccess: () => {
        // Redirect ke halaman login setelah logout
        window.location.href = '/login'; 
      },
      onError: (error) => {
        console.error('Error logging out:', error);
      }
    });
  } catch (error) {
    console.error('Error logging out:', error);
  }
};


const books = ref([
  { judul: 'Manajemen Peminjaman', deskripsi: 'Sistem yang memudahkan Anda untuk meminjam buku secara online dengan cepat dan praktis.', rating: 4.8 },
  { judul: 'Pengiriman Buku', deskripsi: 'Kami akan mengirimkan buku ke alamat Anda dengan aman, memastikan buku tiba dalam kondisi terbaik.', rating: 4.7 },
  { judul: 'Sistem Rekomendasi', deskripsi: 'Menyarankan buku berdasarkan minat Anda untuk pengalaman membaca yang lebih personal.', rating: 4.9 },
  { judul: 'Manajemen Koleksi', deskripsi: 'Membantu Anda mengelola koleksi buku dengan mudah dan efisien.', rating: 4.6 },
  { judul: 'Penelusuran Lanjutan', deskripsi: 'Fitur pencarian lanjutan untuk menemukan buku berdasarkan berbagai kriteria.', rating: 4.5 },
  { judul: 'Berbagi Buku', deskripsi: 'Memungkinkan Anda untuk berbagi buku dengan pengguna lain.', rating: 4.4 },
]);

// Indeks awal untuk buku yang akan ditampilkan
const currentStartIndex = ref(0);

// Fungsi untuk menampilkan 3 buku saat ini
const visibleBooks = computed(() => books.value.slice(currentStartIndex.value, currentStartIndex.value + 3));

// Fungsi untuk menampilkan buku berikutnya
function showNext() {
  if (currentStartIndex.value + 3 < books.value.length) {
    currentStartIndex.value += 3;
  }
}

// Fungsi untuk menampilkan buku sebelumnya
function showPrevious() {
  if (currentStartIndex.value - 3 >= 0) {
    currentStartIndex.value -= 3;
  }
}
</script>

<style scoped>
.landing-page {
  text-align: center;
  padding: 50px;
}
</style>
