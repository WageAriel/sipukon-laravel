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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Username
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fakultas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prodi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody v-if="paginatedUsers.length > 0" class="bg-dark divide-y">
                    <tr v-for="item in paginatedUsers" :key="item.id">
                        <td class="px-6 py-4">{{ item.username }}</td>
                        <td class="px-6 py-4">{{ item.email }}</td>
                        <td class="px-6 py-4">{{ item.nama }}</td>
                        <td class="px-6 py-4">{{ item.role }}</td>
                        <td class="px-6 py-4">{{ item.fakultas }}</td>
                        <td class="px-6 py-4">{{ item.prodi }}</td>
                        <td class="px-6 py-4 flex justify-center items-center space-x-4">
                            <BaseButton
                                :icon="mdiPencil"
                                color="warning"
                                @click="editData(item)"
                            />
                            <BaseButton
                                :icon="mdiDelete"
                                color="danger"
                                @click="confirmDelete(item.id)" 
                            />
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4" class="text-center p-4">No users found.</td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-center mt-4">
                <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="mx-1 px-3 py-1 bg-primary text-white rounded disabled:opacity-50"
                >
                    Prev
                </button>
                <span class="mx-2">{{ currentPage }} / {{ totalPages }}</span>
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="mx-1 px-3 py-1 bg-primary text-white rounded disabled:opacity-50"
                >
                    Next
                </button>
            </div>
        </div>

        <EditModal
            v-if="showEditModal"
            :item="selectedItem"
            :show="showEditModal"
            @close="closeEditModal"
        />
    </CardBox>
</template>

<script setup>
import { ref, computed } from "vue";
import { mdiDelete, mdiPencil } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import Swal from "sweetalert2";
import EditModal from "@/Components/Users/EditModal.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import axios from 'axios'; // Import axios

const props = defineProps({
    users: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const showEditModal = ref(false);
const selectedItem = ref(null);
const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = 20;

const filteredUsers = computed(() => {
    let result = props.users || [];
    if (searchQuery.value) {
        const lowercasedQuery = searchQuery.value.toLowerCase();
        result = result.filter(
            (user) =>
                user.username?.toLowerCase().includes(lowercasedQuery) ||
                user.role?.toLowerCase().includes(lowercasedQuery)
        );
    }
    return result;
});

const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredUsers.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredUsers.value.length / itemsPerPage));

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

const editData = (item) => {
    selectedItem.value = item;
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
    selectedItem.value = null;
};

const confirmDelete = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            deleteUser(id); // Pass the `id` here
        }
    });
};


// Adjusted deleteUser function to handle deletion
const deleteUser = (id) => {
    axios
        .delete(`/dashboard/user/${id}`) // Make sure {id} is appended to the URL
        .then(() => {
            Swal.fire("Deleted!", "The user has been deleted.", "success");
            // Refresh or reload the data after deletion
            location.reload(); // or use a method to fetch updated data
        })
        .catch((error) => {
            console.error(error);
            if (error.response && error.response.status === 401) {
                Swal.fire("Unauthorized!", "You are not authorized to perform this action.", "error");
            } else {
                Swal.fire("Error!", "There was an error deleting the user.", "error");
            }
        });
};

</script>
