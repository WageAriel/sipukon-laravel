<template>
    <div class="fixed inset-0 flex items-center right-[150px] top-[-100px] justify-end z-50">
        <div class="w-[375px] h-[490px] relative bg-white border-2 border-sky-500">
            <div
                class="h-[60px] pl-[13px] pr-[13px] py-2.5 bg-white rounded-tl-[20px] rounded-tr-[20px] flex items-center justify-between">
                <UserCircleIcon class="mt-[10px] w-[50px] h-[50px] text-sky-500" />
                <button @click="$emit('close')"
                    class="w-10 h-10 relative bg-[#00afef] rounded-2xl flex justify-center items-center">
                    <XMarkIcon class="w-10 h-10 relative" />
                </button>
            </div>
            <div class="h-[380px] relative bg-white rounded-bl-[20px] rounded-br-[20px]">
                <div class="left-[20px] top-[79px] absolute flex-col justify-start items-start gap-2 inline-flex">
                    <div class="text-[#131313] text-xl font-semibold font-['Inter'] leading-[31px]">{{ user.username }}
                    </div>
                    <div class="justify-start items-start inline-flex">
                        <div class="justify-start items-center gap-1 flex">
                            <div class="text-[#777777] text-xs font-normal font-['Inter'] leading-[14.40px]">
                                {{ user.email }}</div>
                        </div>
                    </div>
                </div>
                <div
                    class="py-2.5 left-0 top-[173px] absolute flex-col justify-start items-center gap-[13px] inline-flex">
                    <div class="flex-col justify-start items-center gap-4 flex">
                        <div class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                        Nama</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                {{ user.nama }}</div>
                        </div>
                        <div class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                        Status</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                {{user.status}}</div>
                        </div>
                        <div class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                        Prodi</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                {{user.prodi}}</div>
                        </div>
                        <div v-for="(tenggatItem, index) in tenggat" :key="index"  class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                        Tenggat</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">
                                {{ tenggatItem }}
                            </div>
                        </div>
                    </div>
                    <div class="w-[375px] border border-[#131313]/5"></div>
                    <div class="w-[335px] justify-between items-center inline-flex">
                        <div class="justify-start items-center gap-2.5 flex">
                            <button @click="showChangePassword = true"
                                class="flex-col justify-center items-start inline-flex">
                                <div class="text-[#e51f1f] text-[15px] font-medium font-['Inter'] leading-normal">Change
                                    Password</div>
                            </button>
                        </div>
                    </div>
                    <!-- <div class="w-[335px] justify-between items-center inline-flex">
                        <div class="justify-start items-center gap-2.5 flex">
                            <button @click="showDeleteModal = true" class="flex-col justify-center items-start inline-flex">
                                <div class="text-[#e52020] text-[15px] font-medium font-['Inter'] leading-normal">Delete Akun</div>
                            </button>
                        </div>
                    </div> -->
                </div>
                <div
                    class="w-[272px] h-[86px] right-[190px] top-[20px] absolute text-black text-xl font-bold font-['Lato']">
                    Profile</div>
            </div>
        </div>
        <ChangePasswordForm v-if="showChangePassword" @close="showChangePassword = false" />
        <!-- <ConfirmDeleteModal v-if="showDeleteModal" :userId="user.id" @close="showDeleteModal = false" /> -->
    </div>
</template>

<script setup>
    import { UserCircleIcon, XMarkIcon } from '@heroicons/vue/24/solid';
    import { ref, computed } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import ChangePasswordForm from './ChangePasswordForm.vue'; // Import form ganti password
    import ConfirmDeleteModal from './ConfirmDeleteModal.vue'; // Import modal konfirmasi
    import { Inertia } from '@inertiajs/inertia';

    // Mengambil props dari server menggunakan usePage()
    const { props } = usePage();
    console.log('Props dari server:', props);

    // Mendeklarasikan state dengan ref
    const user = ref(props.auth.user);
    const showChangePassword = ref(false); // State untuk menampilkan form ganti password
    const showDeleteModal = ref(false); // State untuk menampilkan modal konfirmasi
    const peminjaman = ref(props.auth.peminjaman || []);
    console.log('Data peminjaman diterima:', peminjaman.value);

    // Menghitung tenggat dengan computed
    const tenggat = computed(() => {
        console.log('Data peminjaman di ProfileView:', peminjaman.value);
        if (peminjaman.value.length > 0) {
            const activeLoan = peminjaman.value.filter((loan) => loan.status_pengembalian === 'Dipinjam');
            console.log('Active Loan:', activeLoan); // Log active loan
            return activeLoan.length > 0
                ? activeLoan.map((loan) => loan.tanggal_pengembalian)
                : ['Belum Ada Tenggat'];
        }
        // return 'Belum Ada Tenggat';
    });
</script>


<style scoped>
    /* Tambahkan styling tambahan di sini jika diperlukan */

</style>
