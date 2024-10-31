<script setup>
import { reactive, ref } from 'vue'
import { mdiBallotOutline, mdiAccount, mdiBookOpenPageVariant, mdiText } from '@mdi/js'
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

        <FormField label="Description" help="Brief description of the book">
          <FormControl v-model="form.description" :icon="mdiText" type="textarea" placeholder="Book description" />
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
