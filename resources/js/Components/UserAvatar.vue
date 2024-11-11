<script setup>
import { computed } from 'vue'

const props = defineProps({
  username: {
    type: String,
    required: true,
    default: 'default-user' // fallback jika username tidak tersedia
  },
  avatar: {
    type: String,
    default: null
  },
  api: {
    type: String,
    default: 'avataaars'
  }
});


const avatar = computed(() => {
  const sanitizedUsername = props.username
    ? props.username.replace(/[^a-z0-9]+/gi, '-')
    : 'default-user'; // fallback jika username tidak tersedia

  return (
    props.avatar ??
    `https://api.dicebear.com/7.x/${props.api}/svg?seed=${sanitizedUsername}.svg`
  );
});


const username = computed(() => props.username)
</script>

<template>
  <div>
    <img
      :src="avatar"
      :alt="username"
      class="rounded-full block h-auto w-full max-w-full bg-gray-100 dark:bg-slate-800"
    />
    <slot />
  </div>
</template>
