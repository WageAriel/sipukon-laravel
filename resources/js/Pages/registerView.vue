<script setup>
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { mdiAccount, mdiMail, mdiLock } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
    prodi: {
        type: Array,
        required: true,
    },
    fakultas: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
    nama: "",
    fakultas: "",
    prodi: '',
});

const fakultasOptions = computed(() => props.fakultas);
const prodiOptions = computed(() => {
    return props.prodi.filter((item) => item.nama_fakultas === form.fakultas);
});

const errors = ref({});
const showAlert = ref(false);

const isFormValid = computed(() => {
    return form.username && form.password && form.nama;
});

const validateForm = () => {
    errors.value = {};
    if (!form.username) {
        errors.value.username = "Username is required.";
    }
    if (!form.password) {
        errors.value.password = "Password is required.";
    }
    if (!form.nama) {
        errors.value.nama = "Nama is required.";
    }
    return Object.keys(errors.value).length === 0;
};

const submit = () => {
    if (validateForm()) {
        showAlert.value = false;
        form.post(route("register.store"), {
            onSuccess: () => {
                reset();
            },
            onError: (errorData) => {
                errors.value = errorData;
                showAlert.value = true;
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
    <div class="w-[1090px] h-[700px] ml-[200px] bg-white flex justify-center items-center">
        <div class="w-[1442px] h-[866px] bg-white rounded-3xl flex flex-col justify-start items-start">
            <div class="w-[1500px] h-[780px] flex justify-start items-start">
                <div class="w-[700px] h-[750px] py-12 bg-white flex flex-col justify-between items-start">
                    <div class="relative h-[900px]">
                        <img class="mt-[50px] ml-[40px] w-32 h-16" src="@/image/logo-uns-besar-biru 1.png" />
                        <div class="absolute top-[120px] left-[40px] w-[550px] h-[auto]">
                            <!-- Header Registrasi -->
                            <div class="absolute top-5 left-0 w-full text-center text-black text-[32px] font-bold capitalize font-['Poppins']">
                                Registrasi
                            </div>

                            <!-- Form -->
                            <div class="absolute top-[100px] left-0 w-full ml-[1px]"> <!-- Tambahkan margin kiri -->
                                <!-- Baris untuk Username dan Nama -->
                                <div class="flex items-center mb-[30px] space-x-[20px]">
                                    <!-- Input Username -->
                                    <div class="w-[50%]">
                                        <label class="block text-[#838282] text-sm font-normal capitalize font-['Poppins']">
                                            Username
                                        </label>
                                        <input
                                            type="text"
                                            id="name"
                                            placeholder="Masukkan username"
                                            v-model="form.username"
                                            class="w-full h-[47.91px] bg-white border border-[#838282] px-4"
                                            @keyup="handleEnterKey"
                                        />
                                        <p v-if="errors.username" class="text-red-500 text-sm mt-2">
                                            {{ errors.username }}
                                        </p>
                                    </div>

                                    <!-- Input Nama -->
                                    <div class="w-[50%]">
                                        <label class="block text-[#838282] text-sm font-normal capitalize font-['Poppins']">
                                            Nama
                                        </label>
                                        <input
                                            type="text"
                                            id="nama"
                                            placeholder="Masukkan nama"
                                            v-model="form.nama"
                                            class="w-full h-[47.91px] bg-white border border-[#838282] px-4"
                                            @keyup="handleEnterKey"
                                        />
                                        <p v-if="errors.nama" class="text-red-500 text-sm mt-2">
                                            {{ errors.nama }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Input Email -->
                                <div class="mb-[30px]">
                                    <label class="block text-[#838282] text-sm font-normal capitalize font-['Poppins']">
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        placeholder="Email"
                                        v-model="form.email"
                                        class="w-full h-[47.91px] bg-white border border-[#838282] px-4"
                                        @keyup="handleEnterKey"
                                    />
                                    <p v-if="errors.email" class="text-red-500 text-sm mt-2">
                                        {{ errors.email }}
                                    </p>
                                </div>

                                <!-- Fakultas Field -->
                                <div class="mb-[30px]">
                                    <label class="block text-[#838282] text-sm font-normal capitalize font-['Poppins']">
                                        Fakultas
                                    </label>
                                    <select
                                        v-model="form.fakultas"
                                        class="w-full h-[47.91px] bg-white border border-[#838282] px-4"
                                        @keyup="handleEnterKey"
                                    >
                                        <option value="" disabled>-- Pilih Fakultas --</option>
                                        <option v-for="item in fakultasOptions" :key="item.id" :value="item.nama_fakultas">
                                            {{ item.nama_fakultas }}
                                        </option>
                                    </select>
                                    <p v-if="errors.fakultas" class="text-red-500 text-sm mt-2">
                                        {{ errors.fakultas }}
                                    </p>
                                </div>

                                <!-- Program Studi Field -->
                                <div class="mb-[30px]">
                                    <label class="block text-[#838282] text-sm font-normal capitalize font-['Poppins']">
                                        Program Studi
                                    </label>
                                    <select
                                        v-model="form.prodi"
                                        class="w-full h-[47.91px] bg-white border border-[#838282] px-4"
                                        @keyup="handleEnterKey"
                                    >
                                        <option value="" disabled>-- Pilih Program Studi --</option>
                                        <option v-for="item in prodiOptions" :key="item.id" :value="item.nama_prodi">
                                            {{ item.nama_prodi }}
                                        </option>
                                    </select>
                                    <p v-if="errors.prodi" class="text-red-500 text-sm mt-2">
                                        {{ errors.prodi }}
                                    </p>
                                </div>

                                <!-- Baris untuk Password dan Confirm Password -->
                                <div class="flex items-center mb-[30px] space-x-[20px]">
                                    <!-- Input Password -->
                                    <div class="w-[50%]">
                                        <label class="block text-[#838282] text-sm font-normal capitalize font-['Poppins']">
                                            Password
                                        </label>
                                        <input
                                            type="password"
                                            id="password"
                                            placeholder="Masukkan password"
                                            v-model="form.password"
                                            class="w-full h-[47.91px] bg-white border border-[#838282] px-4"
                                            @keyup="handleEnterKey"
                                        />
                                        <p v-if="errors.password" class="text-red-500 text-sm mt-2">
                                            {{ errors.password }}
                                        </p>
                                    </div>

                                    <!-- Input Confirm Password -->
                                    <div class="w-[50%]">
                                        <label class="block text-[#838282] text-sm font-normal capitalize font-['Poppins']">
                                            Confirm Password
                                        </label>
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            placeholder="Confirm Password"
                                            v-model="form.password_confirmation"
                                            class="w-full h-[47.91px] bg-white border border-[#838282] px-4"
                                            @keyup="handleEnterKey"
                                        />
                                        <p v-if="errors.password_confirmation" class="text-red-500 text-sm mt-2">
                                            {{ errors.password_confirmation }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Container untuk tombol Submit dan Reset -->
                                <div class="flex space-x-4 w-full mt-4">
                                    <!-- Submit Button -->
                                    <button @click="submit" :disabled="!isFormValid" class="w-full sm:w-[48%] h-12 bg-blue-500 text-white rounded-lg font-semibold">
                                        Registrasi
                                    </button>

                                    <!-- Tombol Reset dengan outline -->
                                    <button @click="reset" class="w-full sm:w-[48%] h-12 border-2 border-red-500 text-red-500 bg-transparent rounded-lg font-semibold">
                                        Reset
                                    </button>
                                </div>

                                <div v-if="form.recentlySuccessful" class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                                    Form submitted successfully!
                                </div>
                                <div v-if="showAlert" class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                                    Please fill in all required fields.
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="/login">
                                <img class="absolute top-[61.5px] left-[544px] w-[30px] h-[30px] z-30" src="@/image/image 5.png" />
                            </a>
                        </div>
                    </div>
                </div>
                <img class="w-[900px] h-[869px]" src="@/image/Perpus-UNS 2.png" />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Add your custom styles here */
</style>
