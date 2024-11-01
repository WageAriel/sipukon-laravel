<script setup>
import {  Head, Link } from '@inertiajs/vue3'
import { mdiAccount, mdiAsterisk } from '@mdi/js'
import LayoutGuest from '@/Layouts/LayoutGuest.vue'
import SectionFullScreen from '@/Components/SectionFullScreen.vue'
import CardBox from '@/Components/CardBox.vue'
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import FormValidationErrors from '@/Components/FormValidationErrors.vue'
import NotificationBarInCard from '@/Components/NotificationBarInCard.vue'
import BaseLevel from '@/Components/BaseLevel.vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  canResetPassword: Boolean,
  status: {
    type: String,
    default: null
  }
})

// const form = useForm({
//   email: '',
//   password: '',
//   remember: [null]
// })

// const submit = () => {
//   form
//     .transform(data => ({
//       ...data,
//       remember: form.remember && form.remember.length ? 'on' : ''
//     }))
//     .post(route('login'), {
//       onFinish: () => form.reset('password'),
//       onSuccess: (response) => {
//         // Gunakan URL redirect dari response
//         if (response.props.redirect) {
//           window.location.href = response.props.redirect;
//         }
//       },
//     });
// }
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: ''
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
    onSuccess: (response) => {
      if (response.props.redirect) {
        window.location.href = response.props.redirect;
      }
    },
  });
};






</script>

<template>
 <div class="w-[1090px] h-[700px] ml-[200px] bg-white flex justify-center items-center">
    <div class="w-[1442px] h-[866px] bg-white rounded-3xl flex flex-col justify-start items-start">
      <div class="w-[1500px] h-[780px] flex justify-start items-start">
        <div class="w-[700px] h-[750px] py-12 bg-white flex flex-col justify-between items-start">
          <div class="relative h-[900px]">
            <img class="absolute top-[61.5px] left-[81px] w-[132.35px] h-[62px]" src="https://via.placeholder.com/132x6" />
            <div class="absolute top-[186.5px] left-[117px] w-[374.69px] h-[479.11px]">
              <div class="absolute top-0 left-[117.93px] w-[142.5px] h-[44.23px] text-center text-black text-[32px] font-bold capitalize font-['Poppins']">Login</div>
              <div class="absolute top-[55.28px] left-[2.46px] w-[372.23px] h-[27.03px] text-center text-[#838282] text-sm font-normal capitalize font-['Poppins']">Login untuk menggunakan layanan kami</div>
              
              <!-- Input Email -->
              <div class="absolute top-[108.11px] left-0 w-[76.17px] h-[23.34px] text-[#838282] text-sm font-normal capitalize font-['Poppins']">Email</div>
              <input type="email" placeholder="Masukkan email" v-model="form.email" class="absolute top-[142.5px] left-0 w-[372.23px] h-[47.91px] bg-white border border-[#838282] px-4" />

              <!-- Input Password -->
              <div class="absolute top-[216.21px] left-0 w-[101.96px] h-[23.34px] text-[#838282] text-sm font-normal capitalize font-['Poppins']">Password</div>
              <input type="password" placeholder="Masukkan password" v-model="form.password" class="absolute top-[250.61px] left-0 w-[372.23px] h-[47.91px] bg-white border border-[#838282] px-4" />

              <!-- Tombol Login -->
              <div class="absolute top-[324.32px] left-0 w-[372.23px] h-[47.91px] bg-[#00afef] flex justify-center items-center cursor-pointer" @click="submit">
                <span class="text-center text-white text-base font-normal capitalize font-['Poppins']">Log In</span>
              </div>

              <div class="absolute top-[372.23px] left-0 w-[372.23px] h-[27.03px] text-center">
                <span class="text-[#838282] text-xs font-normal font-['Poppins']">Belum punya akun? </span>
                <span class="text-[#00afef] text-xs font-normal font-['Poppins']">Buat akun</span>
              </div>

              <!-- Tombol SSO -->
              <div class="absolute top-[431.19px] left-0 w-[372.23px] h-[47.91px]">
                <div class="absolute top-0 left-0 w-[372.23px] h-[47.91px] bg-white border border-[#00afef]"></div>
                <div class="absolute top-0 left-[116.71px] w-[171.99px] h-[47.91px] text-center text-[#00afef] text-base font-normal capitalize font-['Poppins']">Log In Email SSO</div>
                <img class="absolute top-[7.37px] left-[84.76px] w-[31.94px] h-[31.94px]" src="https://via.placeholder.com/32x32" />
              </div>
            </div>
            <img class="absolute top-[61.5px] left-[544px] w-[30px] h-[30px]  z-30" src="../../image/image 5.png" />
            <div class="absolute top-[67.5px] left-[410px] w-[121px] h-[19px] text-center text-black text-base font-bold capitalize font-['Poppins']">Hubungi kami</div>
          </div>
        </div>
        <img class="w-[900px] h-[869px]" src="../../image/Perpus-UNS 2.png" />
      </div>
    </div>
  </div>
  <!-- <LayoutGuest>
    <Head title="Login" />

    <SectionFullScreen
      v-slot="{ cardClass }"
      bg="purplePink"
    >
      <CardBox
        :class="cardClass"
        is-form
        @submit.prevent="submit"
      >
        <FormValidationErrors />

        <NotificationBarInCard 
          v-if="status"
          color="info"
        >
          {{ status }}
        </NotificationBarInCard>

        <FormField
          label="Email"
          label-for="email"
          help="Please enter your email"
        >
          <FormControl
            v-model="form.email"
            :icon="mdiAccount"
            id="email"
            autocomplete="email"
            type="email"
            required
          />
        </FormField>

        <FormField
          label="Password"
          label-for="password"
          help="Please enter your password"
        >
          <FormControl
            v-model="form.password"
            :icon="mdiAsterisk"
            type="password"
            id="password"
            autocomplete="current-password"
            required
          />
        </FormField>

        <FormCheckRadioGroup
          v-model="form.remember"
          name="remember"
          :options="{ remember: 'Remember' }"
        />

        <BaseDivider />

        <BaseLevel>
          <BaseButtons>
            <BaseButton
              type="submit"
              color="info"
              label="Login"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            />
            <BaseButton
              v-if="canResetPassword"
              route-name="password.request"
              color="info"
              outline
              label="Remind"
            />
          </BaseButtons>
          <Link
            :href="route('register')"
          >
            Register
          </Link>
        </BaseLevel>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest> -->
</template>
