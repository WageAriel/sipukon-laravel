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
    fakultass: Array,
});

const emit = defineEmits(["close"]);

const form = useForm({
    _method: "PUT", // Add this line to force PUT method
    nama_prodi: "",
});

watch(
    () => props.item,
    (newItem) => {
        if (newItem) {
            form.nama_prodi = newItem.nama_prodi;
            form.nama_fakultas = newItem.nama_fakultas;  // Pastikan nama_fakultas terisi dengan benar
        }
    },
    { immediate: true }
);

const submit = () => {
    form.post(route("prodi.update", props.item.id), {
        preserveState: true,
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            emit("close");
            Swal.fire({
                title: "Berhasil!",
                text: "Identitas Prodi berhasil diperbarui.",
                icon: "success",
                confirmButtonColor: "#3085d6",
            }).then(() => {
                emit("close"); // Tutup modal setelah notifikasi sukses
            });
        },
        onError: (errors) => {
            Swal.fire({
                title: "Gagal!",
                text: "Terjadi kesalahan saat memperbarui Prodi.",
                icon: "error",
                confirmButtonColor: "#d33",
            });
            console.log(errors); // Debug jika diperlukan
        },
    });
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
                                Edit Prodi
                            </h3>
                            <div class="mt-2">
                                <FormField label="Nama Fakultas">
    <select v-model="form.nama_fakultas" class="form-select mt-1 block w-full">
        <option value="" disabled>Pilih Fakultas</option>
        <!-- Loop Fakultas berdasarkan nama_fakultas -->
        <option v-for="fakultas in fakultass" :key="fakultas.id" :value="fakultas.nama_fakultas">
            {{ fakultas.nama_fakultas }}
        </option>
    </select>
</FormField>
                                <FormField label="Nama Prodi">
                                    <FormControl
                                        v-model="form.nama_prodi"
                                        :icon="mdiAccount"
                                    />
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
