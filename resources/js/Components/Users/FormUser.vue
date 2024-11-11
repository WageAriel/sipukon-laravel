<script setup>
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { mdiAccount, mdiMail, mdiLock } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseDivider from "@/Components/BaseDivider.vue";

const selectOptions = [
    { label: "Admin", value: "admin" },
    { label: "User", value: "user" },
];

const form = useForm({
    name: "",
    email: "",
    password: "",
    role: "",
    nama: ""
});

const errors = ref({});
const showAlert = ref(false);

const isFormValid = computed(() => {
    return form.username && form.password && form.role && form.nama;
});

const validateForm = () => {
    errors.value = {};
    if (!form.username) {
        errors.value.username = "Name is required.";
    }
    if (!form.password) {
        errors.value.password = "Password is required.";
    }
    if (!form.role) {
        errors.value.role = "Role is required.";
    }
    return Object.keys(errors.value).length === 0;
};

const submit = () => {
    if (validateForm()) {
        showAlert.value = false;
        form.post(route("user.store"), {
            onSuccess: () => {
                reset();
            },
            onError: (errorData) => {
                errors.value = errorData;
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
    <CardBox form @submit.prevent="submit">
        <FormField label="Username">
            <FormControl v-model="form.username" id="name" :icon="mdiAccount" />
            <p v-if="errors.username" class="text-red-500 text-sm mt-0">
                {{ errors.username }}
            </p>
        </FormField>

        <FormField label="Email">
            <FormControl v-model="form.email" id="email" :icon="mdiMail" placeholder="Enter email">
              <p v-if="errors.email" class="text-red-500 text-sm mt-1">
                  {{ errors.email }}
              </p>
            </FormControl>
        </FormField>

        <FormField label="Password">
            <FormControl v-model="form.password" id="password" :icon="mdiLock" type="password" autocomplete="new-password" placeholder="Password">
            <p v-if="errors.password" class="text-red-500 text-sm mt-0">
                {{ errors.password }}
            </p>
            </FormControl>
        </FormField>

        <FormField label="Role">
            <select v-model="form.role" class="form-select">
                <option value="" disabled>Select an option</option>
                <option v-for="option in selectOptions" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
            <p v-if="errors.role" class="text-red-500 text-sm mt-0">
                {{ errors.role }}
            </p>
        </FormField>

        <template #footer>
            <BaseButtons>
                <BaseButton type="submit" color="success" label="Submit" @click="submit" />
                <BaseButton type="reset" color="danger" @click="reset" outline label="Reset" />
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

<style scoped>
.form-select {
    padding: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid #cbd5e0;
}
</style>
