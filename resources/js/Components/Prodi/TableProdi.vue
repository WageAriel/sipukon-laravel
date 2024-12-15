<script setup>
import { ref, computed} from "vue";
import { mdiDelete, mdiPencil } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import EditModal from "@/Components/Prodi/EditModal.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});

const showEditModal = ref(false);
const selectedItem = ref(null);
const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = 20;

const sortedProdis = computed(() => {
    let hasil = props.data || [];
    return hasil.sort((a, b) => {
        if (a.nama_fakultas?.toLowerCase() < b.nama_fakultas?.toLowerCase()) {
            return -1;
        }
        if (a.nama_fakultas?.toLowerCase() > b.nama_fakultas?.toLowerCase()) {
            return 1;
        }
        return 0;
    });
});

const filteredProdis = computed(() => {
    let result = sortedProdis.value;
    if (searchQuery.value) {
        const lowercasedQuery = searchQuery.value.toLowerCase();
        result = result.filter(
            (prodi) =>
                prodi.nama_prodi?.toLowerCase().includes(lowercasedQuery) ||
                prodi.nama_fakultas?.toLowerCase().includes(lowercasedQuery)
        );
    }
    return result;
});

const paginatedProdis = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredProdis.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredProdis.value.length / itemsPerPage));

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

const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("prodi.destroy", id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire(
                        "Deleted!",
                        "The item has been deleted.",
                        "success"
                    );
                },
                onError: (errors) => {
                    Swal.fire(
                        "Error!",
                        "There was a problem deleting the file.",
                        "error"
                    );
                    console.log(errors);
                },
            });
        }
    });
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
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Nama Fakultas
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Nama Prodi
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody v-if="paginatedProdis.length > 0" class="bg-dark divide-y">
                <tr v-for="item in paginatedProdis" :key="item.id">
                    <td class="px-6 py-4">
                        {{ item.nama_fakultas }}
                    </td>
                    <td class="px-6 py-4">
                        {{ item.nama_prodi }}
                    </td>
                    <td class="px-6 py-4">
                        <BaseButton
                            :icon="mdiPencil"
                            color="warning"
                            @click="editData(item)"
                            class="mx-4"
                        />
                        <BaseButton
                            :icon="mdiDelete"
                            color="danger"
                            @click="confirmDelete(item.id)"
                        />
                    </td>
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

        <EditModal
            v-if="showEditModal"
            :item="selectedItem"
            :show="showEditModal"
            @close="closeEditModal"
        />
    </CardBox>
</template>
