<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButton from "@/Components/BaseButton.vue";
import { mdiAccount } from "@mdi/js";
import Swal from "sweetalert2";

const props = defineProps({
    item: Object,
    show: Boolean,
});

const emit = defineEmits(["close"]);

const form = useForm({
    _method: "PUT", // Add this line to force PUT method
    status_pengembalian: "",
});

watch(
    () => props.item,
    (newItem) => {
        if (newItem) {
            form.status_pengembalian = newItem.status_pengembalian;
        }
    },
    { immediate: true }
);

const submit = async () => {
    // Cek jika status pengembalian adalah 'Dikembalikan'
    if (form.status_pengembalian === 'Dikembalikan') {
        const tanggalPengembalian = new Date(props.item.tanggal_pengembalian);
        const tanggalSekarang = new Date();
        const overdueDays = Math.floor((tanggalSekarang - tanggalPengembalian) / (1000 * 3600 * 24)); // Hitung jumlah hari keterlambatan
        
        // Jika keterlambatan lebih dari 0 hari
        if (overdueDays > 0) {
            const overdueWeeks = Math.ceil(overdueDays / 7); // Hitung minggu keterlambatan
            const denda = Math.ceil(overdueWeeks) * 5000; // Denda per minggu

            // Menampilkan SweetAlert dengan informasi denda
            const result = await Swal.fire({
                title: "Peminjaman Telah Terlambat!",
                text: `Denda yang dikenakan adalah Rp ${denda.toLocaleString()}. Apakah Anda ingin melanjutkan?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Lanjutkan",
                cancelButtonText: "Batal"
            });

            // Jika admin memilih untuk melanjutkan
            if (result.isConfirmed) {
                // Kirim permintaan untuk memperbarui status pengembalian dan menambahkan denda
                form.denda = denda; // Menambahkan denda ke form jika perlu
                form.post(route("peminjaman.update", props.item.id), {
                    preserveState: true,
                    preserveScroll: true,
                    forceFormData: true,
                    onSuccess: () => {
                        emit("close");
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Status pengembalian berhasil diperbarui dan denda telah dicatat.",
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        }).then(() => {
                            emit("close"); // Tutup modal setelah notifikasi sukses
                        });
                    },
                    onError: (errors) => {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat memperbarui status.",
                            icon: "error",
                            confirmButtonColor: "#d33",
                        });
                        console.log(errors); // Debug jika diperlukan
                    },
                });
            } else {
                // Jika admin batal, tutup modal
                emit("close");
            }
        } else {
            // Jika tidak ada keterlambatan, langsung update status tanpa denda
            form.post(route("peminjaman.update", props.item.id), {
                preserveState: true,
                preserveScroll: true,
                forceFormData: true,
                onSuccess: () => {
                    emit("close");
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Status pengembalian berhasil diperbarui.",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    }).then(() => {
                        emit("close");
                    });
                },
                onError: (errors) => {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat memperbarui status.",
                        icon: "error",
                        confirmButtonColor: "#d33",
                    });
                    console.log(errors); // Debug jika diperlukan
                },
            });
        }
    } else {
        // Jika status bukan "Dikembalikan", langsung update tanpa pengecekan denda
        form.post(route("peminjaman.update", props.item.id), {
            preserveState: true,
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                emit("close");
                Swal.fire({
                    title: "Berhasil!",
                    text: "Status pengembalian berhasil diperbarui.",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                }).then(() => {
                    emit("close"); // Tutup modal setelah notifikasi sukses
                });
            },
            onError: (errors) => {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat memperbarui status.",
                    icon: "error",
                    confirmButtonColor: "#d33",
                });
                console.log(errors); // Debug jika diperlukan
            },
        });
    }
};

</script>

<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" v-if="show">
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
                >​</span
            >
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class=" px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                        >
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900"
                            >
                                Edit Status Peminjaman
                            </h3>
                            <div class="mt-2">
                                <FormField label="Status Pengembalian">
                                    <select
                                        v-model="form.status_pengembalian"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sky-500"
                                    >
                                        <option value="Dipinjam">Dipinjam</option>
                                        <option value="Dikembalikan">
                                            Dikembalikan
                                        </option>
                                        <option value="Diantar">Diantar</option>
                                    </select>
                                </FormField>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class=" px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                >
                    <BaseButton
                        type="button"
                        color="info"
                        label="Save"
                        @click="submit"
                    />
                    <BaseButton
                        class="mx-4"
                        type="button"
                        color="warning"
                        label="Cancel"
                        @click="$emit('close')"
                        outline
                    />
                </div>
            </div>
        </div>
    </div>
</template>
