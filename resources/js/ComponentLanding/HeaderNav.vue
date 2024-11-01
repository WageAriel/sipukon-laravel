<template>
    <header class="flex overflow-hidden flex-wrap gap-10 px-9 py-3.5 whitespace-nowrap bg-white bg-opacity-0 max-md:px-5">
      <nav class="flex gap-10 items-center text-base font-medium capitalize text-neutral-900 max-md:max-w-full">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/d32ba014fd2f43b69edb017a43e6b422/41eea9458c841a5ef98e7c9c655029d8ae99c3d588ddd3cd33cf0049962fba1e?apiKey=d32ba014fd2f43b69edb017a43e6b422&"
          alt="Company logo"
          class="object-contain shrink-0 self-stretch max-w-full aspect-[2.11] w-[207px]"
        />
        <a href="#home" class="self-stretch my-auto">HOME</a>
        <a href="#library" class="self-stretch my-auto">LIBRARY</a>
        <a href="#lending" class="self-stretch my-auto">LENDING</a>
        <a href="#about" class="self-stretch my-auto">ABOUT</a>
      </nav>
      <div class="flex gap-4 my-auto text-sm font-extrabold text-center ml-[600px] text-white">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/d32ba014fd2f43b69edb017a43e6b422/70ae46c9b276bc3e2a70e0880c2c18f82ac4e26f8512fa945770e15590e71200?apiKey=d32ba014fd2f43b69edb017a43e6b422&"
          alt="User avatar"
          class="object-contain shrink-0 rounded-3xl aspect-square w-[60px]"
        />
        <!-- Gunakan Link dari @inertiajs/vue3 -->
        <Link
  :href="route('login')"
  class="overflow-hidden gap-2.5 self-start px-10 py-5 bg-sky-500 rounded-xl max-md:px-5"
>
  Login
</Link>

      </div>
    </header>
  </template>
  
  <script>
  import { Link } from '@inertiajs/vue3'
  
  export default {
    name: 'NavigationBar',
    components: {
      Link,
    },
  }
  </script>
  