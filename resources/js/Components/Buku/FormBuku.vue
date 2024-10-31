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

        <FormField label="Description">
            <FormControl v-model="form.description" name="description" textarea />
            <p v-if="errors.description" class="text-red-500 text-sm mt-1">
                {{ errors.description }}
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
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import MultipleFormFilePicker from "@/Components/MultipleFormFilePicker.vue";

const form = useForm({
    title: "",
    author: "",
    description: "",
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
    if (!form.cover_image) {
        errors.value.cover_image = "Cover image harus diisi";
    }
    return Object.keys(errors.value).length === 0;
};

const submit = () => {
    if (validateForm()) {
        showAlert.value = false;

        const formData = new FormData();
        formData.append("title", form.title);
        formData.append("author", form.author);
        formData.append("description", form.description);
        if (form.cover_image) {
            formData.append("cover_image", form.cover_image);
        }

        form.post(route("buku.store"), {
            data: formData,
            onSuccess: () => {
                reset();
            },
            onError: (errors) => {
                console.log(errors);
            },
        });
    } else {
        showAlert.value = true;
    }
};

const reset = () => {
    form.reset();
    errors.value = {};
    showAlert.value = false;
};
</script>
