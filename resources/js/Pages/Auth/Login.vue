<script setup>
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, onMounted } from 'vue';

const props = defineProps({
  canResetPassword: Boolean,
  status: {
    type: String,
    default: null
  }
});

// State form
const form = useForm({
  email: '',
  password: ''
});

// State untuk "Remember Me" checkbox
const rememberMe = ref(false);

// Cek apakah ada data email tersimpan saat komponen dimuat
onMounted(() => {
  const savedEmail = localStorage.getItem('savedEmail');
  if (savedEmail) {
    form.email = savedEmail; // Isi otomatis email dari localStorage
  }
});

// Fungsi submit untuk login
const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
    onSuccess: (response) => {
      if (response.props.redirect) {
        window.location.href = response.props.redirect;
      }
      // Notifikasi login berhasil
      Swal.fire({
        icon: 'success',
        title: 'Login Berhasil',
        text: 'Akun Anda telah berhasil login!',
      });

      // Simpan email ke localStorage jika "Remember Me" dipilih
      if (rememberMe.value) {
        localStorage.setItem('savedEmail', form.email);
      } else {
        localStorage.removeItem('savedEmail'); // Hapus jika tidak dipilih
      }
    },
  });
};

// Fungsi untuk menangani submit dengan Enter
const handleEnterKey = (event) => {
  if (event.key === 'Enter') {
    submit();
  }
};
</script>

<template>
  <div class="w-[1090px] h-[700px] ml-[200px] bg-white flex justify-center items-center">
    <div class="w-[1442px] h-[866px] bg-white rounded-3xl flex flex-col justify-start items-start">
      <div class="w-[1500px] h-[780px] flex justify-start items-start">
        <div class="w-[700px] h-[750px] py-12 bg-white flex flex-col justify-between items-start">
          <div class="relative h-[900px]">
            <img class="absolute top-[61.5px] left-[81px] w-[132.35px] h-[62px]" src="https://via.placeholder.com/132x62" />
            <div class="absolute top-[186.5px] left-[117px] w-[374.69px] h-[479.11px]">
              <div class="absolute top-0 left-[117.93px] w-[142.5px] h-[44.23px] text-center text-black text-[32px] font-bold capitalize font-['Poppins']">Login</div>
              <div class="absolute top-[55.28px] left-[2.46px] w-[372.23px] h-[27.03px] text-center text-[#838282] text-sm font-normal capitalize font-['Poppins']">Login untuk menggunakan layanan kami</div>
              
              <!-- Input Email -->
              <div class="absolute top-[108.11px] left-0 w-[76.17px] h-[23.34px] text-[#838282] text-sm font-normal capitalize font-['Poppins']">Email</div>
              <input
                type="email"
                placeholder="Masukkan email"
                v-model="form.email"
                class="absolute top-[142.5px] left-0 w-[372.23px] h-[47.91px] bg-white border border-[#838282] px-4"
                @keyup="handleEnterKey"
              />

              <!-- Input Password -->
              <div class="absolute top-[216.21px] left-0 w-[101.96px] h-[23.34px] text-[#838282] text-sm font-normal capitalize font-['Poppins']">Password</div>
              <input
                type="password"
                placeholder="Masukkan password"
                v-model="form.password"
                class="absolute top-[250.61px] left-0 w-[372.23px] h-[47.91px] bg-white border border-[#838282] px-4"
                @keyup="handleEnterKey"
              />

              <!-- Remember Me Checkbox -->
              <div class="absolute top-[300px] left-0 flex items-center space-x-2">
                <input type="checkbox" v-model="rememberMe" />
                <label class="text-[#838282] text-sm font-normal capitalize font-['Poppins']">Ingat saya</label>
              </div>

              <!-- Tombol Login -->
              <div class="absolute top-[324.32px] left-0 w-[372.23px] h-[47.91px] bg-[#00afef] flex justify-center items-center cursor-pointer" @click="submit">
                <span class="text-center text-white text-base font-normal capitalize font-['Poppins']">Log In</span>
              </div>

              <div class="absolute top-[372.23px] left-0 w-[372.23px] h-[27.03px] text-center">
                <span class="text-[#838282] text-xs font-normal font-['Poppins']">Belum punya akun? </span>
                <a href="/register" class="text-[#00afef] text-xs font-normal font-['Poppins']">Buat akun</a>
              </div>

              <!-- Tombol SSO -->
              <div class="absolute top-[431.19px] left-0 w-[372.23px] h-[47.91px]">
                <div class="absolute top-0 left-0 w-[372.23px] h-[47.91px] bg-white border border-[#00afef]"></div>
                <div class="absolute top-0 left-[116.71px] w-[171.99px] h-[47.91px] text-center text-[#00afef] text-base font-normal capitalize font-['Poppins']">Log In Email SSO</div>
                <img class="absolute top-[7.37px] left-[84.76px] w-[31.94px] h-[31.94px]" src="https://via.placeholder.com/32x32" />
              </div>
            </div>
            <img class="absolute top-[61.5px] left-[544px] w-[30px] h-[30px] z-30" src="../../image/image 5.png" />
            <div class="absolute top-[67.5px] left-[410px] w-[121px] h-[19px] text-center text-black text-base font-bold capitalize font-['Poppins']">Hubungi kami</div>
          </div>
        </div>
        <img class="w-[900px] h-[869px]" src="../../image/Perpus-UNS 2.png" />
      </div>
    </div>
  </div>
</template>
