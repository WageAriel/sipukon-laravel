import { createRouter, createWebHistory } from 'vue-router';
import FormPeminjaman from '@/components/FormPeminjaman.vue';
import BookCard from '@/components/BookCard.vue';

const routes = [
  {
    path: '/form-peminjaman',
    name: 'formPeminjaman',
    component: FormPeminjaman,
  },
  {
    path: '/book-card',
    name: 'bookCard',
    component: BookCard,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
