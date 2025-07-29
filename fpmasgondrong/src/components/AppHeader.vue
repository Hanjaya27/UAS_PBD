<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <header class="header">
    <div class="header-inner d-flex justify-content-between align-items-center">
      <img src="@/assets/images/navbar/logobaru2.png" alt="Logo Rental" class="img-logo" />
      <span class="brand">MasGondrong Rent</span>
    </div>

    <div class="right">
      <nav class="navbar">
        <router-link to="/">Beranda</router-link>
        <router-link to="/kelompok">Tim</router-link>
        <router-link to="/cara-sewa">Cara Sewa</router-link>
        <router-link to="/riwayat">Riwayat Pemesanan</router-link>
      </nav>

    <div class="btn-group">
      <router-link v-if="!isLoggedIn" to="/login" class="btn-login">Login</router-link>
      <button v-else @click="logout" class="btn-login">Logout</button>
    </div>

    </div>
  </header>
</template>

<script>
export default {
  name: 'AppHeader',
  data() {
    return {
      isLoggedIn: false
    }
  },
  created() {
    this.syncLoginState()

    // Dengarkan perubahan login di seluruh halaman
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
      this.$router.push('/')
    },
    syncLoginState() {
  const userLoggedIn = localStorage.getItem('userLoggedIn') === 'true'
  const userData = localStorage.getItem('user')

  this.isLoggedIn = userLoggedIn && userData !== null
}

  }
}

</script>
