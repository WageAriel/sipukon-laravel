<script setup>
import { useMainStore } from '@/Stores/main'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import UserAvatar from '@/Components/UserAvatar.vue'
// import { useDarkModeStore } from '@/Stores/darkMode.js'

const userName = computed(() => usePage().props.auth.user.name)
const mainStore = useMainStore()
</script>

<template>
  <UserAvatar :username="userName" api="initials">
    <slot />
  </UserAvatar>
</template>
