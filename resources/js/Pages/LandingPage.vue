<template>
  <Head title="Landing" />
  <div class="landing-page">
    <h1>Welcome to the Landing Page</h1>
    <p>This is a simple landing page for users.</p>
    
    <nav class="w-full mt-5">
      <ul>
        <li
          class="flex gap-2.5 justify-between px-5 mt-5 w-full font-medium text-red-600 leading-[155%] max-w-[375px]">
          <a @click="logout" class="cursor-pointer flex items-center justify-between w-full">
            Log out
            <ChevronRightIcon class="w-5 h-5" />
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, onBeforeMount } from 'vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ChevronRightIcon } from '@heroicons/vue/24/solid';

const logout = async () => {
  try {
    await router.post(route("logout"), {
      onSuccess: () => {
        // Redirect ke halaman login setelah logout
        window.location.href = '/login'; 
      },
      onError: (error) => {
        console.error('Error logging out:', error);
      }
    });
  } catch (error) {
    console.error('Error logging out:', error);
  }
};

</script>

<style scoped>
.landing-page {
  text-align: center;
  padding: 50px;
}
</style>
