<template>
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-4 w-96">
            <h2 class="text-lg font-semibold text-center mb-2 text-blue-600">Konfirmasi Hapus Akun</h2>
            <p class="text-center mb-4 text-gray-700 text-sm leading-normal whitespace-normal break-words">
                Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-around">
                <button 
                    @click="$emit('close')" 
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition"
                >
                    Batal
                </button>
                <button 
                    @click="confirmDelete" 
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                >
                    Hapus Akun
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        userId: Number,
    },
    setup(props, { emit }) {
        const confirmDelete = () => {
            Inertia.delete(`/users/${props.userId}`, {
                onSuccess: () => {
                    emit('close');
                }
            });
        };

        return {
            confirmDelete,
        };
    }
};
</script>

<style scoped>
/* Pastikan teks dalam modal tetap dalam batas */
.text-center {
    text-align: center;
}

/* Mengatur batas untuk modal agar lebih rapi */
.bg-white {
    max-width: 90%; /* Menghindari terlalu lebar */
}

/* Styling tambahan untuk teks */
.mb-4 {
    margin-bottom: 1rem; /* Ruang di bawah teks */
}

/* Aturan untuk mengatur ukuran teks agar sesuai dengan box */
.text-sm {
    font-size: 0.875rem; /* Ukuran font kecil */
}

.leading-normal {
    line-height: 1.5; /* Jarak antar baris */
}

/* Pastikan teks dapat membungkus dengan baik */
.whitespace-normal {
    white-space: normal; /* Mengizinkan teks membungkus */
}

.break-words {
    word-break: break-word; /* Memecah kata panjang jika perlu */
}
</style>
