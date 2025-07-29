<template>
  <header class="header">
    <div class="header-inner d-flex justify-content-between align-items-center">
      <img src="@/assets/images/navbar/logobaru2.png" alt="Logo Rental" class="img-logo" />
      <span class="brand">MasGondrong Rent - ADMIN</span>
    </div>

    <div class="right">
      <nav class="navbar">
        <router-link to="/admin/dashboard">Dashboard</router-link>
        <router-link to="/admin/pemesanan">Pemesanan</router-link>
        <router-link to="/admin/pembayaran">Pembayaran</router-link>
        <router-link to="/admin/kendaraan">Kendaraan</router-link>
        <router-link to="/admin/pengguna">Pengguna</router-link>
      </nav>

      <div class="btn-group">
        <button v-if="isLoggedIn" @click="logout" class="btn-login">Logout</button>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'NavbarAdmin',
  data() {
    return {
      isLoggedIn: false
    }
  },
  created() {
    this.syncLoginState()
    window.addEventListener('user-login-changed', this.syncLoginState)
  },
  beforeUnmount() {
    window.removeEventListener('user-login-changed', this.syncLoginState)
  },
  methods: {
    logout() {
      localStorage.removeItem('user')
      localStorage.removeItem('userLoggedIn')
      window.dispatchEvent(new Event('user-login-changed'))
      this.$router.push('/adminlogin')
    },
    syncLoginState() {
      this.isLoggedIn = localStorage.getItem('userLoggedIn') === 'true'
    }
  }
}
</script>
