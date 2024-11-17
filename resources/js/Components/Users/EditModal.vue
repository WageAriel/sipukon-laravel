<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class=" px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Data</h3>
                            <div class="mt-2">
                                <FormField label="Username">
                                    <FormControl v-model="form.username" :icon="mdiAccount" />
                                </FormField>
                                <FormField label="Email">
                                    <FormControl v-model="form.email" :icon="mdiMail" />
                                </FormField>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <BaseButton type="button" color="info" label="Save" @click="submit" />
                    <BaseButton class="mx-4" type="button" color="warning" label="Cancel" @click="$emit('close')" outline />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiAccount, mdiMail } from '@mdi/js';

const props = defineProps({
    item: {
        type: Object,
        default: null,
    }, // Data pengguna yang akan diedit
    show: Boolean, // Mengontrol visibilitas modal
});

const emit = defineEmits(["close"]);

const form = useForm({
    _method: 'PUT', // Ensures it is treated as a PUT request
    username: '',
    email: '',
});

watch(
    () => props.item,
    (newItem) => {
        if (newItem) {
            form.username = newItem.username;
            form.email = newItem.email;
        }
    },
    { immediate: true }
);

const submit = () => {
    form.put(route('user.update', props.item.id), {  // Ensure this matches Route::put('/dashboard/user/{id}')
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            emit('close');
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
};


</script>

<style scoped>
.form-select {
    padding: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid #cbd5e0;
}
</style>
