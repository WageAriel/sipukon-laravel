<template>
    <HeaderNav/>
    <div class="flex overflow-hidden flex-col bg-white">
        <main class="flex flex-col items-start self-center mt-[50px] ml-5 w-full max-w-[1195px] max-md:mt-10 max-md:max-w-full">
            <section class="self-stretch max-md:max-w-full">
                <div class="flex gap-5 max-md:flex-col">
                    <div class="flex flex-col w-6/12 max-md:ml-0 max-md:w-full">
                        <div class="flex flex-col grow text-5xl font-bold text-black max-md:mt-10 max-md:max-w-full max-md:text-4xl">
                            <img loading="lazy" src="@/image/AboutPerpus.png" />
                            <h2 class="self-start mt-14 max-md:mt-10 max-md:text-4xl">
                                Misi <span class="text-sky-500">Kami</span>
                            </h2>
                        </div>
                    </div>
                    <div class="flex flex-col ml-5 w-6/12 max-md:ml-0 max-md:w-full">
                        <div class="flex flex-col mt-4 font-bold text-black max-md:mt-10 max-md:max-w-full">
                            <h1 class="self-start text-5xl max-md:text-4xl">
                                About <span class="text-sky-500">Us</span>
                            </h1>
                            <p class="mt-14 text-2xl text-justify max-md:mt-10 max-md:max-w-full">
                                Selamat datang di Sistem Informasi Perpustakaan Online SI-PukOn.<br />Platform kami dirancang untuk memberikan pengalaman yang mudah dan ramah pengguna dalam mengakses dan mengelola kebutuhan perpustakaan Anda. Dengan perkembangan teknologi digital yang pesat, kami percaya bahwa pengalaman perpustakaan tradisional harus berkembang juga, menawarkan akses yang lebih mudah ke informasi dan buku, di mana pun Anda berada.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mt-14 text-2xl font-bold text-justify text-black max-md:mt-10 max-md:max-w-full">
                <p>
                    Di SI-PukOn, kami berkomitmen untuk:
                </p>
                <ul class="list-disc">
                    <li>Memfasilitasi Akses ke Pengetahuan: Kami menyediakan akses mudah ke koleksi buku dan sumber daya digital yang luas, memastikan pengetahuan selalu ada di genggaman Anda.</li>
                    <li>Menyederhanakan Proses Peminjaman: Dengan sistem online kami, Anda dapat meminjam dan mengembalikan buku dengan mudah, serta memilih opsi pengiriman buku ke rumah Anda.</li>
                    <li>Meningkatkan Pengalaman Pengguna: Platform kami dirancang untuk intuitif dan mudah digunakan, sehingga siapa pun dapat dengan mudah menavigasi, mencari, dan mengelola akun perpustakaan mereka.</li>
                </ul>
            </section>
            <h2 class="mt-16 text-5xl font-bold text-black max-md:mt-10 max-md:text-4xl">
                <span class="text-sky-500">Fitur</span> yang <span class="text-sky-500">kami</span> tawarkan
            </h2>
            <section class="mt-12 text-2xl font-bold text-black max-md:mt-10 max-md:max-w-full">
                <ul class="list-disc">
                    <li>Login & Registrasi: Buat akun dengan mudah atau masuk untuk mengelola interaksi perpustakaan Anda.</li>
                    <li>Pencarian: Cari melalui koleksi buku kami yang luas berdasarkan judul, penulis, atau genre.</li>
                    <li>Rekomendasi Buku: Dapatkan rekomendasi buku yang dipersonalisasi berdasarkan preferensi dan riwayat peminjaman Anda.</li>
                    <li>Peminjaman Buku: Pilih buku yang tersedia dan pinjam secara online.</li>
                    <li>Denda & Sanksi: Sistem kami menghitung denda untuk keterlambatan pengembalian dan membantu Anda tetap mematuhi batasan peminjaman.</li>
                    <li>Layanan Pengiriman: Pilih untuk mengirim buku yang Anda pinjam ke alamat Anda (jika tersedia di wilayah Anda).</li>
                </ul>
            </section>
        </main>
    </div>
    <FooterView/>
</template>

<script setup>
import HeaderNav from '@/ComponentLanding/HeaderNav.vue'
import FooterView from '@/ComponentLanding/FooterView.vue'
</script>

<script>
export default {
    name: 'AboutPage'
}
</script>
