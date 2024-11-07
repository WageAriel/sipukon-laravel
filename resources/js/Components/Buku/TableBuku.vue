<script setup>
import { ref, nextTick } from "vue";
import { mdiDelete, mdiPencil } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import EditBookModal from "@/Components/Buku/EditModal.vue";

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});

const showEditModal = ref(false);
const selectedItem = ref(null);

const form = useForm({});

const confirmDelete = async (id) => {
    const result = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        zIndex: 9999, // Menambahkan z-index
    });

    if (result.isConfirmed) {
        form.delete(route("buku.destroy", id), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: async () => {
                await nextTick();
                Swal.fire({
                    title: "Deleted!",
                    text: "The item has been deleted successfully.",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    zIndex: 9999, // Menambahkan z-index
                });
            },
            onError: async (errors) => {
                await nextTick();
                Swal.fire({
                    title: "Error!",
                    text: "There was a problem deleting the item.",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    zIndex: 9999, // Menambahkan z-index
                });
                console.log(errors);
            },
        });
    }
};

const editData = (item) => {
    selectedItem.value = item;
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
    selectedItem.value = null;
};

</script>

<template>
    <CardBox>
        <table class="min-w-full divide-y mx-auto">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">tahun</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-dark divide-y">
                <tr v-for="item in data" :key="item.id">
                    <td class="px-6 py-4 text-center">{{ item.title }}</td>
                    <td class="px-6 py-4 text-center">{{ item.author }}</td>
                    <td class="px-6 py-4 text-center">{{ item.isbn }}</td>
                    <td class="px-6 py-4 text-center">{{ item.publisher }}</td>
                    <td class="px-6 py-4 text-center">{{ item.tahun }}</td>
                    <td class="px-6 py-4 text-center">
                        <img :src="`/storage/book_covers/${item.cover_image}`" alt="Cover Image" class="w-20 h-20 object-cover mx-auto" />
                    </td>
                    <td class="px-6 py-4 text-center">
                        <BaseButton :icon="mdiPencil" color="warning" @click="editData(item)" class="mx-4" />
                        <BaseButton :icon="mdiDelete" color="danger" @click="confirmDelete(item.id)" />
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Edit Buku -->
        <EditBookModal v-if="showEditModal" :item="selectedItem" :show="showEditModal" @close="closeEditModal" />
    </CardBox>
</template>

<style scoped>
/* Override styling untuk memastikan SweetAlert di tengah layar */
.swal2-container {
    position: fixed !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    z-index: 9999 !important;
}
</style>
