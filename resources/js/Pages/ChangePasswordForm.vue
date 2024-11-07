<template>
    <div class="p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-black mb-4">Ganti Password</h2>
        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block text-sm text-black font-medium">Password Lama</label>
                <input
                    type="password"
                    v-model="oldPassword"
                    class="mt-1 block w-full border-gray-300 text-black rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    required
                />
            </div>
            <div class="mb-4">
                <label class="block text-sm text-black font-medium">Password Baru</label>
                <input
                    type="password"
                    v-model="newPassword"
                    class="mt-1 block w-full border-gray-300 text-black rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    required
                />
            </div>
            <button
                type="submit"
                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md"
            >
                Ganti Password
            </button>
            <button
                type="button"
                @click="$emit('close')"
                class="mt-2 ml-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md"
            >
                Batal
            </button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    setup(props, { emit }) {
        const oldPassword = ref('');
        const newPassword = ref('');

        const submit = () => {
            Inertia.post('/change-password', {
                old_password: oldPassword.value,
                new_password: newPassword.value,
            }, {
                onSuccess: () => {
                    emit('close');
                    // Add any additional success logic here, e.g., show a notification
                }
            });
        };

        return {
            oldPassword,
            newPassword,
            submit,
        };
    }
};
</script>

<style scoped>
/* Tambahkan styling tambahan di sini jika diperlukan */
</style>
