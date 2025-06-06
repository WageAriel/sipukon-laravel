<script setup>
import { ref, computed, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import CardBox from '@/Components/CardBox.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import axios from 'axios';

const form = useForm({
    nama_fakultas: '',
    nama_prodi: ''
});

const fakultass = ref([]);

const errors = ref({});
const showAlert = ref(false);

const isFormValid = computed(() => {
    return form.nama_fakultas && form.nama_prodi;
});

const validateForm = () => {
    errors.value = {};
    if (!form.nama_fakultas) {
        errors.value.nama_fakultas = 'Nama Fakultas is required.';
    }
    if (!form.nama_prodi) {
        errors.value.nama_prodi = 'Nama Prodi is required.';
    }
    return Object.keys(errors.value).length === 0;
};

const submit = () => {
    if (validateForm()) {
        showAlert.value = false;
        form.post(route('prodi.store'), {
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
onMounted(() => {
    // Fetch fakultas data from the backend
    axios.get('/data-fakultas').then((response) => {
        fakultass.value = response.data.data;
    });
});
</script>

<template>
    <CardBox @submit.prevent="submit">
        <FormField label="Nama Fakultas">
            <select v-model="form.nama_fakultas" class="form-select">
                <option value="" disabled>Pilih Fakultas</option>
                <option v-for="fakultas in fakultass" :key="fakultas.id" :value="fakultas.nama_fakultas">
                    {{ fakultas.nama_fakultas }}
                </option>
            </select>
            <p v-if="errors.nama_fakultas" class="text-red-500 text-sm">
                {{ errors.nama_fakultas }}
            </p>
        </FormField>
        <FormField label="Nama Prodi">
            <FormControl v-model="form.nama_prodi" placeholder="Masukkan nama Prodi" />
        </FormField>
            <p v-if="errors.nama_prodi" class="text-red-500 text-sm">
                {{ errors.nama_prodi }}
            </p>
        <template #footer>
            <BaseButtons>
                <BaseButton type="submit" color="success" label="Submit" @click="submit"/>
                <BaseButton type="reset" color="danger" outline label="Reset" @click="reset" />
            </BaseButtons>
        </template>
    </CardBox>
    <div v-if="form.recentlySuccessful" class="mt-4 p-4 bg-green-100 text-green-700 rounded">
        Form submitted successfully!
    </div>
    <div v-if="showAlert" class="mt-4 p-4 bg-red-100 text-red-700 rounded">
        Please fill in all required fields.
    </div>
</template>
