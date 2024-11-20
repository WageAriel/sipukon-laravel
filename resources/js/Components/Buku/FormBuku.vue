<template>
    <CardBox @submit.prevent="submit" enctype="multipart/form-data">
        <h1 class="text-xl font-bold">Upload Data Buku</h1>
        <BaseDivider />
        
        <FormField label="Title">
            <FormControl v-model="form.title" name="title" />
            <p v-if="errors.title" class="text-red-500 text-sm mt-1">
                {{ errors.title }}
            </p>
        </FormField>

        <FormField label="Author">
            <FormControl v-model="form.author" name="author" />
            <p v-if="errors.author" class="text-red-500 text-sm mt-1">
                {{ errors.author }}
            </p>
        </FormField>

        <FormField label="ISBN">
    <FormControl v-model="form.isbn" name="isbn" />
    <p v-if="errors.isbn" class="text-red-500 text-sm mt-1">
        {{ errors.isbn }}
    </p>
</FormField>

<FormField label="Publisher">
    <FormControl v-model="form.publisher" name="publisher" />
    <p v-if="errors.publisher" class="text-red-500 text-sm mt-1">
        {{ errors.publisher }}
    </p>
</FormField>

<FormField label="Tahun">
    <FormControl v-model="form.tahun" name="tahun" type="number" />
    <p v-if="errors.tahun" class="text-red-500 text-sm mt-1">
        {{ errors.tahun }}
    </p>
</FormField>


        <FormField label="Cover Image (image max 10 MB)">
            <MultipleFormFilePicker
                v-model="form.cover_image"
                label="Upload"
                name="cover_image"
            />
            <p v-if="errors.cover_image" class="text-red-500 text-sm mt-1">
                {{ errors.cover_image }}
            </p>
        </FormField>

        <template #footer>
            <BaseButtons>
                <BaseButton
                    type="submit"
                    color="success"
                    label="Submit"
                    @click="submit"
                />
                <BaseButton
                    type="reset"
                    color="danger"
                    @click="reset"
                    outline
                    label="Reset"
                />
            </BaseButtons>
        </template>
    </CardBox>

    <div
        v-if="form.recentlySuccessful"
        class="mt-4 p-4 bg-green-100 text-green-700 rounded"
    >
        Data berhasil ditambahkan
    </div>
    <div v-if="showAlert" class="mt-4 p-4 bg-red-100 text-red-700 rounded">
        Harus isi data di formnya
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import MultipleFormFilePicker from "@/Components/MultipleFormFilePicker.vue";
import Swal from 'sweetalert2';

const form = useForm({
    title: "",
    author: "",
    isbn: "",         // Tambahkan field ISBN
    publisher: "",    // Tambahkan field Publisher
    tahun: "",        // Tambahkan field Tahun
    cover_image: null,
});

const errors = ref({});
const showAlert = ref(false);

const validateForm = () => {
    errors.value = {};
    if (!form.title) {
        errors.value.title = "Title harus diisi";
    }
    if (!form.author) {
        errors.value.author = "Author harus diisi";
    }
    if (!form.isbn) {
        errors.value.isbn = "ISBN harus diisi"; // Validasi untuk ISBN
    }
    if (!form.publisher) {
        errors.value.publisher = "Publisher harus diisi"; // Validasi untuk Publisher
    }
    if (!form.tahun) {
        errors.value.tahun = "Tahun harus diisi"; // Validasi untuk Tahun
    }
    if (!form.cover_image) {
        errors.value.cover_image = "Cover image harus diisi";
    }
    return Object.keys(errors.value).length === 0;
};

const submit = () => {
    if (validateForm()) {

        const formData = new FormData();
        formData.append("title", form.title);
        formData.append("author", form.author);
        formData.append("isbn", form.isbn); // Tambahkan ISBN ke formData
        formData.append("publisher", form.publisher); // Tambahkan Publisher ke formData
        formData.append("tahun", form.tahun); // Tambahkan Tahun ke formData
        if (form.cover_image) {
            formData.append("cover_image", form.cover_image);
        }

        form.post(route("buku.store"), {
            data: formData,
            onSuccess: async() => {
                await nextTick();
                Swal.fire({
                    title: "Berhasil!",
                    text: "Data buku berhasil disimpan.",
                    icon: "success",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6"
                }).then(() => {
                    reset(); // Reset form setelah pengguna menekan "OK" di swal
                });
            },
            onError: (errors) => {
                console.log(errors);
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat menyimpan data buku.",
                    icon: "error",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#d33"
                });
            },
        });
    }
};

const reset = () => {
    form.reset();
    errors.value = {};
};
</script>

