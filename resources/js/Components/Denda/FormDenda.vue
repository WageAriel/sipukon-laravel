<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import CardBox from '@/Components/CardBox.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';

const form = useForm({
    nama_fakultas: ''
});

const errors = ref({});
const showAlert = ref(false);

const isFormValid = computed(() => {
    return form.nama_fakultas;
});

const validateForm = () => {
    errors.value = {};
    if (!form.nama_fakultas) {
        errors.value.nama_fakultas = 'Nama fakultas is required.';
    }
    return Object.keys(errors.value).length === 0;
};

const submit = () => {
    if (validateForm()) {
        showAlert.value = false;
        form.post(route('fakultas.store'), {
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

<template>
    <CardBox @submit.prevent="submit">
        <FormField label="Nama fakultas">
            <FormControl v-model="form.nama_fakultas" placeholder="Masukkan nama Fakultas" />
        </FormField>
            <p v-if="errors.nama_fakultas" class="text-red-500 text-sm">
                {{ errors.nama_fakultas }}
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
