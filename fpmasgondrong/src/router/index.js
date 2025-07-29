import { createRouter, createWebHistory } from 'vue-router'

import AdminLogin from '@/views/AdminLogin.vue'
import Dashboard from '@/views/Dashboard.vue';
import ManagePemesanan from '@/views/ManagePemesanan.vue';
import ManagePembayaran from '@/views/ManagePembayaran.vue';
import ManageKendaraan from '@/views/ManageKendaraan.vue';
import ManagePengguna from '@/views/ManagePengguna.vue';
import ManageAdmin from '@/views/ManageAdmin.vue';

const routes = [
  { path: '/', redirect: '/adminlogin' }, // Redirect otomatis ke adminlogin

  // Admin routes
  { path: '/adminlogin', name: 'AdminLogin', component: AdminLogin, meta: { showHeader: false } },
  { path: '/admin/dashboard', name: 'Dashboard', component: Dashboard, meta: { showHeader: false } },
  { path: '/admin/pemesanan', name: 'ManagePemesanan', component: ManagePemesanan, meta: { showHeader: false } },
  { path: '/admin/pembayaran', name: 'ManagePembayaran', component: ManagePembayaran, meta: { showHeader: false } },
  { path: '/admin/kendaraan', name: 'ManageKendaraan', component: ManageKendaraan, meta: { showHeader: false } },
  { path: '/admin/pengguna', name: 'ManagePengguna', component: ManagePengguna, meta: { showHeader: false } },
  { path: '/admin/tambah-kendaraan', name: 'TambahKendaraan', component: () => import('@/views/TambahKendaraan.vue') },
  { path: '/admin/edit-kendaraan/:id', name: 'EditKendaraan', component: () => import('@/views/EditKendaraan.vue') },
  { path: '/admin/kelola-admin', name: 'ManageAdmin', component: ManageAdmin, meta: { showHeader: false } }
];



const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router