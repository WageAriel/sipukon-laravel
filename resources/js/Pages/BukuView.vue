<script setup>
import { reactive, ref } from 'vue'
import { mdiAccount, mdiBookOpenPageVariant, mdiStar, mdiBarcode, mdiPublish} from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import { useForm } from "@inertiajs/vue3";
import CardBox from '@/components/CardBox.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import FormFilePicker from "@/components/FormFilePicker.vue"
import Tablebuku from "@/components/Buku/TableBuku.vue"
import Swal from "sweetalert2";


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
        showAlert.value = false;

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

defineProps({
    data: {
        type: Array,
        required: true,
    },
});
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Buku" />
    <SectionMain>
      <CardBox form @submit.prevent="submit">
        <h1 class="text-xl font-bold">Form Buku</h1>
        <BaseDivider />

        <FormField label="Title">
          <FormControl v-model="form.title" :icon="mdiBookOpenPageVariant" placeholder="Enter book title" />
        </FormField>

        <FormField label="Author">
          <FormControl v-model="form.author" :icon="mdiAccount" placeholder="Enter author name" />
        </FormField>

        <FormField label="ISBN">
            <FormControl v-model="form.isbn" placeholder="Enter ISBN">
              <p v-if="errors.isbn" class="text-red-500 text-sm mt-1">
                  {{ errors.isbn }}
              </p>
            </FormControl>
        </FormField>

        <FormField label="Publisher">
            <FormControl v-model="form.publisher" placeholder="Enter publisher name">
              <p v-if="errors.publisher" class="text-red-500 text-sm mt-1">
                  {{ errors.publisher }}
              </p>
            </FormControl>
        </FormField>

        <FormField label="Tahun">
            <FormControl v-model="form.tahun" placeholder="Enter years">
              <p v-if="errors.tahun" class="text-red-500 text-sm mt-1">
                  {{ errors.tahun }}
              </p>
            </FormControl>
        </FormField>

        <FormField label="Cover Image (image max 10 MB)">
          <FormFilePicker v-model="form.cover_image" label="Upload" name="cover_image" />
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
      <Tablebuku :data="data" />
    </SectionMain>
  </LayoutAuthenticated>
</template>
