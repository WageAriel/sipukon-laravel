<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButton from "@/Components/BaseButton.vue";
import FormFilePicker from "@/Components/FormFilePicker.vue";
import CardBox from "../CardBox.vue";
import Swal from "sweetalert2";

const props = defineProps({
    item: Object,
    show: Boolean,
});

const emit = defineEmits(["close"]);

const form = useForm({
    _method: "PUT",
    title: "",
    author: "",
    isbn: "",         // Tambahkan field ISBN
    publisher: "",    // Tambahkan field Publisher
    tahun: "",        // Tambahkan field Tahun
    cover_image: null,
});

// Watch untuk update data form berdasarkan props.item
watch(
    () => props.item,
    (newItem) => {
        if (newItem) {
            form.title = newItem.title || "";
            form.author = newItem.author || "";
            form.isbn = newItem.isbn || "";         // Update ISBN
            form.publisher = newItem.publisher || ""; // Update Publisher
            form.tahun = newItem.tahun || "";        // Update Tahun
            form.cover_image = null; // Reset file input setiap kali item berubah
        }
    },
    { immediate: true }
);

const submit = () => {
    form.post(route("buku.update", props.item.id), {
        preserveState: true,
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            emit("close");
            Swal.fire({
                title: "Berhasil!",
                text: "Identitas Buku berhasil diperbarui.",
                icon: "success",
                confirmButtonColor: "#3085d6",
            }).then(() => {
                emit("close"); // Tutup modal setelah notifikasi sukses
            });
        },
        onError: (errors) => {
            Swal.fire({
                title: "Gagal!",
                text: "Terjadi kesalahan saat memperbarui Buku.",
                icon: "error",
                confirmButtonColor: "#d33",
            });
            console.log(errors); // Debug jika diperlukan
        },
    });
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 p-6 relative">
            <CardBox>
                <div class="sm:items-start">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 text-center">Edit Book</h3>
                    <div class="mt-4">
                        <FormField label="Title">
                            <FormControl v-model="form.title" name="title" />
                        </FormField>
                        <FormField label="Author">
                            <FormControl v-model="form.author" name="author" />
                        </FormField>
                        <FormField label="ISBN">
                            <FormControl v-model="form.isbn" name="isbn" />
                        </FormField>
                        <FormField label="Publisher">
                            <FormControl v-model="form.publisher" name="publisher" />
                        </FormField>
                        <FormField label="Tahun">
                            <FormControl v-model="form.tahun" name="tahun" type="number" />
                        </FormField>
                        <FormField label="Cover Image (image max 10 MB)">
                            <FormFilePicker
                                v-model="form.cover_image"
                                label="Upload"
                                name="cover_image"
                            />
                        </FormField>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
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
            </CardBox>
        </div>
    </div>
</template>

<style scoped>
/* Pengaturan untuk modal agar tetap berada di atas semua elemen */
.z-50 {
    z-index: 50;
}
</style>
