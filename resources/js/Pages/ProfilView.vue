<template>
    <div class="fixed inset-0 flex items-center right-[150px] top-[-50px] justify-end z-50">
        <div class="w-[375px] h-[550px] relative bg-white border-2 border-sky-500">
            <div class="h-[60px] pl-[13px] pr-[13px] py-2.5 bg-white rounded-tl-[20px] rounded-tr-[20px] flex items-center justify-between">
                <UserCircleIcon class="mt-[10px] w-[50px] h-[50px] text-sky-500" />
                <button @click="$emit('close')" class="w-10 h-10 relative bg-[#00afef] rounded-2xl flex justify-center items-center">
                    <XMarkIcon class="w-10 h-10 relative"/>
                </button>
            </div>
            <div class="h-[443px] relative bg-white rounded-bl-[20px] rounded-br-[20px]">
                <div class="left-[20px] top-[79px] absolute flex-col justify-start items-start gap-2 inline-flex">
                    <div class="text-[#131313] text-xl font-semibold font-['Inter'] leading-[31px]">{{ user.username }}</div>
                    <div class="justify-start items-start inline-flex">
                        <div class="justify-start items-center gap-1 flex">
                            <div class="text-[#777777] text-xs font-normal font-['Inter'] leading-[14.40px]">{{ user.email }}</div>
                        </div>
                    </div>
                </div>
                <div class="py-2.5 left-0 top-[173px] absolute flex-col justify-start items-center gap-[13px] inline-flex">
                    <div class="flex-col justify-start items-center gap-4 flex">
                        <div class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">Nama</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">{{ user.nama }}</div>
                        </div>
                        <div class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">Status</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">{{user.status}}</div>
                        </div>
                        <div class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">Prodi</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">{{user.prodi}}</div>
                        </div>
                        <div class="w-[335px] justify-between items-center inline-flex">
                            <div class="justify-start items-center gap-2.5 flex">
                                <div class="flex-col justify-center items-start inline-flex">
                                    <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">Tenggat</div>
                                </div>
                            </div>
                            <div class="text-[#131313] text-[15px] font-medium font-['Inter'] leading-normal">9 Desember 2024</div>
                        </div>
                    </div>
                    <div class="w-[375px] h-[0px] border border-[#131313]/5"></div>
                    <div class="w-[335px] justify-between items-center inline-flex">
                        <div class="justify-start items-center gap-2.5 flex">
                            <button @click="showChangePassword = true" class="flex-col justify-center items-start inline-flex">
                                <div class="text-[#e51f1f] text-[15px] font-medium font-['Inter'] leading-normal" >Change Password</div>
                            </button>
                        </div>
                    </div>
                    <div class="w-[335px] justify-between items-center inline-flex">
                        <div class="justify-start items-center gap-2.5 flex">
                            <button @click="showDeleteModal = true" class="flex-col justify-center items-start inline-flex">
                                <div class="text-[#e52020] text-[15px] font-medium font-['Inter'] leading-normal">Delete Akun</div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-[272px] h-[86px] right-[190px] top-[20px] absolute text-black text-xl font-bold font-['Lato']">Profile</div>
            </div>
        </div>
        <ChangePasswordForm v-if="showChangePassword" @close="showChangePassword = false" />
        <ConfirmDeleteModal v-if="showDeleteModal" :userId="user.id" @close="showDeleteModal = false" />
    </div>
</template>

<script>
    import { UserCircleIcon, XMarkIcon } from '@heroicons/vue/24/solid';
    import { ref } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import ChangePasswordForm from './ChangePasswordForm.vue'; // Import form ganti password
    import ConfirmDeleteModal from './ConfirmDeleteModal.vue'; // Import modal konfirmasi
    import { Inertia } from '@inertiajs/inertia';

    export default {
        components: {
            UserCircleIcon,
            XMarkIcon,
            ChangePasswordForm, // Daftarkan komponen
            ConfirmDeleteModal, // Daftarkan modal konfirmasi
        },
        setup() {
            const { props } = usePage();
            const user = ref(props.auth.user);
            const showChangePassword = ref(false); // State untuk menampilkan form ganti password
            const showDeleteModal = ref(false); // State untuk menampilkan modal konfirmasi

            const goToChangePassword = () => {
        Inertia.visit('/change-password'); // Redirects to the change password route
    };

            const logout = () => {
                Inertia.post(route('logout'), {
                    onSuccess: () => {
                        Inertia.reload({
                            only: ['auth']
                        });
                    }
                });
            };

            return {
                user,
                logout,
                showChangePassword, // Return state
                showDeleteModal, // Return state
                goToChangePassword,
            };
        }
    };
</script>

<style scoped>
    /* Tambahkan styling tambahan di sini jika diperlukan */
</style>
