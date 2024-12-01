<script setup>
import { ref, nextTick, computed} from "vue";
import { mdiDelete, mdiPencil } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import EditBookModal from "@/Components/Buku/EditModal.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";


const props = defineProps({
    data: {
        type: Array,
        required: true,
        // default: () => [],
    },
});

const showEditModal = ref(false);
const selectedItem = ref(null);
const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = 20;

const filteredBukus = computed(() => {
    let result = props.data || [];
    if (searchQuery.value) {
        const lowercasedQuery = searchQuery.value.toLowerCase();
        result = result.filter(
            (buku) =>
                buku.title?.toLowerCase().includes(lowercasedQuery) ||
                buku.author?.toLowerCase().includes(lowercasedQuery)
        );
    }
    return result;
});

const paginatedBukus = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredBukus.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredBukus.value.length / itemsPerPage));

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

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
        <div class="overflow">
        <div class="search-form flex items-center gap-2 mb-4 my-2">
                <FormField>
                    <FormControl
                        v-model="searchQuery"
                        placeholder="Search by name"
                    />
                </FormField>
            </div>
        <table class="min-w-full divide-y mx-auto">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">tahun</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Dipinjam</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody v-if="paginatedBukus.length > 0" class="bg-dark divide-y">
                <tr v-for="item in paginatedBukus" :key="item.id">
                    <td class="px-6 py-4 text-center">{{ item.title }}</td>
                    <td class="px-6 py-4 text-center">{{ item.author }}</td>
                    <td class="px-6 py-4 text-center">{{ item.isbn }}</td>
                    <td class="px-6 py-4 text-center">{{ item.publisher }}</td>
                    <td class="px-6 py-4 text-center">{{ item.tahun }}</td>
                    <td class="px-6 py-4 text-center">
                        <img :src="`/storage/book_covers/${item.cover_image}`" alt="Cover Image" class="w-20 h-20 object-cover mx-auto" />
                    </td>
                    <td class="px-6 py-4 text-center">{{ item.banyaknya_dipinjam }}</td>
                    <td class="px-6 py-4 text-center flex justify-center items-center space-x-4">
                        <BaseButton :icon="mdiPencil" color="warning" @click="editData(item)" />
                        <BaseButton :icon="mdiDelete" color="danger" @click="confirmDelete(item.id)" />
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                    <tr>
                        <td colspan="4" class="text-center p-4">No buku found.</td>
                    </tr>
                </tbody>
        </table>
        <div class="flex justify-center mt-4">
                <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="mx-1 px-3 py-1 bg-primary text-black rounded disabled:opacity-50"
                >
                    Prev
                </button>
                <span class="mx-2">{{ currentPage }} / {{ totalPages }}</span>
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="mx-1 px-3 py-1 bg-primary text-black rounded disabled:opacity-50"
                >
                    Next
                </button>
            </div>

        <!-- Modal Edit Buku -->
    </div>
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
