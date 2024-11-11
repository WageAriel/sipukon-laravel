<template>
    <footer class="w-full bg-sky-500 py-8 mt-[100px]">
      <div class="w-full max-w-screen-xl mx-auto px-4 flex flex-col items-center">
        
        <!-- Konten utama footer dengan grid layout -->
        <div class="w-full grid grid-cols-1 md:grid-cols-4 gap-8">
          
          <!-- Kolom Logo dan Tentang Website -->
          <div class="flex flex-col items-start text-white text-xl font-extrabold">
            <img
              loading="lazy"
              src="@/image/LogoUNS 1.png"
              alt="UNS Logo"
              class="w-[200px] h-auto mb-4"
            />
          </div>
  
          <!-- Kolom Menu Navigasi -->
          <nav class="text-white text-xl font-extrabold">
            <h2>Menu</h2>
            <ul class="mt-4 space-y-2">
              <Link href="/" class="block">Home</Link>
              <Link href="/library" class="block">Library</Link>
              <Link href="/lending" class="block">Lending</Link>
              <Link href="/about" class="block">About</Link>
            </ul>
          </nav>
  
          <!-- Kolom Kontak Kami -->
          <div class="text-white text-xl font-extrabold">
            <h2>Contact Us</h2>
            <ul class="mt-4 space-y-2">
              <button class="flex items-center gap-2">
                <MapPinIcon class="w-5 h-5"/>
                Locations
              </button>
              <button class="flex items-center gap-2">
                <EnvelopeIcon class="w-5 h-5"/>
                Email
              </button>
              <button class="flex items-center gap-2">
                <PhoneIcon class="w-5 h-5"/>
                Phone
              </button>
            </ul>
          </div>
  
          <!-- Kolom Sosial Media -->
          <div class="text-white text-xl font-extrabold">
            <h2>Sosial Media</h2>
            <ul class="mt-4 space-y-2">
              <li class="flex items-center gap-2">
                <img src="@/image/InstagramBold.png" class="w-5 h-5" />
                Instagram
              </li>
              <li class="flex items-center gap-2">
                <img src="@/image/Facebook.png" alt="Social Icon" class="w-5 h-5" />
                Facebook
              </li>
              <li class="flex items-center gap-2">
                <img src="@/image/X.png" alt="Social Icon" class="w-5 h-5" />
                Twitter
              </li>
            </ul>
          </div>
        </div>
  
        <!-- Garis Pemisah -->
        <div class="w-full max-w-[1264px] my-8 border-t-4 border-white"></div>
  
        <!-- Copyright -->
        <p class="text-center text-white text-lg font-extrabold">Si-PukOn 2024. All Rights Reserved</p>
      </div>
    </footer>
  </template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { MapPinIcon, EnvelopeIcon} from '@heroicons/vue/24/outline';
import { PhoneIcon } from '@heroicons/vue/24/solid';
</script>