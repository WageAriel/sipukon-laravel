<script setup>
import { ref, nextTick } from "vue";
import { mdiDelete, mdiPencil, mdiTableBorder } from "@mdi/js";
import Swal from "sweetalert2";
import { mdiAccount, mdiBookOpenPageVariant, mdiStar, mdiBarcode, mdiPublish} from '@mdi/js'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import SectionMain from '@/components/SectionMain.vue'
import { useForm } from "@inertiajs/vue3";
import CardBox from '@/components/CardBox.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});

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
        <table class="min-w-full divide-y mx-auto">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peminjam</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Peminjaman</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengembalian</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-dark divide-y">
                <tr v-for="item in data" :key="item.id">
                    <td class="px-6 py-4 text-center">{{ item.judul }}</td>
                    <td class="px-6 py-4 text-center">{{ item.nama_peminjam }}</td>
                    <td class="px-6 py-4 text-center">{{ item.tanggal_peminjaman }}</td>
                    <td class="px-6 py-4 text-center">{{ item.tanggal_pengembalian }}</td>
                    <td class="px-6 py-4 text-center">
                        <BaseButton :icon="mdiDelete" color="danger" @click="confirmReturn(item.id)" />
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>
</SectionMain>
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
