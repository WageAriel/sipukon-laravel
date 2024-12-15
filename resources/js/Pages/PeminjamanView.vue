<script setup>
import { ref, nextTick, computed } from "vue";
import {mdiPencil, mdiTableBorder } from "@mdi/js";
import Swal from "sweetalert2";
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import SectionMain from '@/components/SectionMain.vue'
import { useForm } from "@inertiajs/vue3";
import CardBox from '@/components/CardBox.vue'
import BaseButton from '@/components/BaseButton.vue'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import EditStatus from '@/Components/Peminjaman/EditModal.vue'
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});

// State untuk modal
const showModal = ref(false);
const currentItem = ref(null);
const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = 20;

const filteredPeminjamans = computed(() => {
    let result = props.data || [];
    if (searchQuery.value) {
        const lowercasedQuery = searchQuery.value.toLowerCase();
        result = result.filter(
            (peminjaman) =>
                peminjaman.nama_peminjam?.toLowerCase().includes(lowercasedQuery) ||
                peminjaman.status_pengembalian?.toLowerCase().includes(lowercasedQuery)
        );
    }
    return result;
});

const paginatedPeminjamans = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredPeminjamans.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredPeminjamans.value.length / itemsPerPage));

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const openModal = (item) => {
    currentItem.value = item;
    showModal.value = true;
};

const closeModal = () => {
    currentItem.value = null;
    showModal.value = false;
};

const form = useForm({});

const confirmReturn = async (id) => {
    const result = await Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data peminjaman akan dihapus dan buku dianggap telah dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, kembalikan!",
        cancelButtonText: "Batal",
        zIndex: 9999,
    });

    if (result.isConfirmed) {
        form.delete(route("peminjaman.destroy", id), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: async (response) => {
                await nextTick();
                Swal.fire({
                    title: "Dikembalikan!",
                    text: "Data peminjaman berhasil dihapus.",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    zIndex: 9999,
                });
            },
            onError: async (errors) => {
                await nextTick();
                Swal.fire({
                    title: "Error!",
                    text: errors.response?.data?.message || "Terjadi kesalahan saat menghapus data peminjaman.",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    zIndex: 9999,
                });
                console.log(errors);
            },
        });
    }
};
</script>

<template>
    <LayoutAuthenticated>
        <SectionMain>
        <CardBox>
            <SectionTitleLineWithButton :icon="mdiTableBorder" title="Daftar Peminjaman" main>
            </SectionTitleLineWithButton>
            <div class="search-form flex items-center gap-2 mb-4 my-2">
                <FormField>
                    <FormControl
                        v-model="searchQuery"
                        placeholder="Search by name"
                    />
                </FormField>
            </div>
        <table class="min-w-full divide-y mx-auto">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peminjam</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Peminjaman</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengembalian</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody v-if="paginatedPeminjamans.length > 0" class="bg-dark divide-y">
                <tr v-for="item in paginatedPeminjamans" :key="item.id">
                    <td class="px-6 py-4 text-center">{{ item.judul }}</td>
                    <td class="px-6 py-4 text-center">{{ item.nama_peminjam }}</td>
                    <td class="px-6 py-4 text-center">{{ item.tanggal_peminjaman }}</td>
                    <td class="px-6 py-4 text-center">{{ item.tanggal_pengembalian }}</td>
                    <td class="px-6 py-4 text-center">{{ item.metode_pengambilan }}</td>
                    <td class="px-6 py-4 text-center">{{ item.alamat}}</td>
                    <td class="px-6 py-4 text-center">{{ item.status_pengembalian }}</td>
                    <td class="px-6 py-4 text-center">{{ item.kondisi_buku }}</td>
                    <td class="px-6 py-4 text-center">
                        <BaseButton :icon="mdiPencil" color="warning"
                        @click="openModal(item)" />
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-center mt-4">
                <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="mx-1 px-3 py-1 bg-primary text-black rounded disabled:opacity-50"
                >
                    Prev
                </button>
                <span class="mx-2">{{ currentPage }} / {{ totalPages }}</span>
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="mx-1 px-3 py-1 bg-primary text-black rounded disabled:opacity-50"
                >
                    Next
                </button>
            </div>
    </CardBox>
</SectionMain>
<EditStatus
            :item="currentItem"
            :show="showModal"
            @close="closeModal"
        />
    </LayoutAuthenticated>
    
</template>

<style scoped>
/* Override styling untuk memastikan SweetAlert di tengah layar */
.swal2-container {
    position: fixed !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    z-index: 9999 !important;
}
</style>
