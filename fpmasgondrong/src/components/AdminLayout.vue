<template>
  <div class="wrapper layout-fixed layout-navbar-fixed sidebar-mini">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand custom-navbar fixed-top">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <span class="nav-link font-weight-bold">MasGondrong Rent - ADMIN</span>
        </li>
      </ul>

      <!-- Right navbar -->
      <ul class="navbar-nav ml-auto logout-nav">
        <li class="nav-item">
          <button
            v-if="isLoggedIn"
            @click="logout"
            class="btn btn-sm btn-outline-danger logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="#" class="brand-link">
        <img
          src="@/assets/images/navbar/logobaru2.png"
          alt="Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: .8"
        />
        <span class="brand-text font-weight-light">Admin MasGondrong</span>
      </a>

      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <router-link to="/admin/dashboard" class="nav-link" exact-active-class="active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/kendaraan" class="nav-link" exact-active-class="active">
                <i class="nav-icon fas fa-car"></i>
                <p>Kelola Kendaraan</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/pemesanan" class="nav-link" exact-active-class="active">
                <i class="nav-icon fas fa-book"></i>
                <p>Kelola Pemesanan</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/pembayaran" class="nav-link" exact-active-class="active">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Kelola Pembayaran</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/pengguna" class="nav-link" exact-active-class="active">
                <i class="nav-icon fas fa-users"></i>
                <p>Kelola Pengguna</p>
              </router-link>
            </li>
            <!-- ✅ Tambahan Kelola Admin -->
            <li class="nav-item">
              <router-link to="/admin/kelola-admin" class="nav-link" exact-active-class="active">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>Kelola Admin</p>
              </router-link>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <slot />
      </div>
    </section>
  </div>
</template>

<script>
export default {
  props: {
    navbarColor: {
      type: String,
      default: '#4B0082'
    }
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('isLoggedIn');
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('isLoggedIn');
      this.$router.push('/adminlogin');
    }
  }
};
</script>

<style scoped>
.brand-image {
  width: 35px;
  height: 35px;
}

.custom-navbar {
  background-color: #53c9f5;
  color: white;
  height: 70px;
  font-size: 1.4rem;
  display: flex;
  align-items: center;
  z-index: 1040;
}

.custom-navbar .nav-link {
  color: white;
  font-size: 1.4rem;
}

.custom-navbar .btn {
  font-size: 1rem;
}

.logout-nav {
  margin-right: 275px !important;
}

.logout-btn {
  z-index: 1050;
  position: relative;
}

/* Sidebar */
.sidebar .nav-link p,
.sidebar .nav-link i {
  font-size: 1.05rem;
}

.sidebar .nav-link {
  padding: 10px 15px;
}

body {
  margin: 0 !important;
  padding: 0 !important;
}

.wrapper {
  width: 100%;
  max-width: 100vw;
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
}

.content-wrapper {
  padding-top: 50px;
  padding-left: 200px;
  padding-right: 20px;
  min-height: 100vh;
  box-sizing: border-box;
}

.content-header .d-flex {
  flex-wrap: wrap;
  gap: 1rem;
}

@media (max-width: 576px) {
  .content-header .btn {
    width: 100%;
  }
}

.main-header {
  top: 0;
  position: fixed;
  width: 100%;
  z-index: 1030;
}

.content {
  margin-left: 250px;
}

.card {
  width: 100%;
  max-width: 100%;
  overflow-x: auto;
}

.sidebar .nav-sidebar > .nav-item > .nav-link {
  padding-top: 16px !important;
  padding-bottom: 16px !important;
  padding-left: 20px !important;
  font-size: 1.2rem !important;
  height: auto !important;
  line-height: 1.6 !important;
}

.sidebar .nav-sidebar > .nav-item > .nav-link i.nav-icon {
  font-size: 1.4rem !important;
  margin-right: 12px;
}

.sidebar .nav-sidebar > .nav-item > .nav-link p {
  font-size: 1.2rem !important;
  margin: 0;
}

.sidebar .nav-sidebar > .nav-item {
  margin-bottom: 8px;
}

.sidebar .nav-link.active {
  background-color: #007bff !important;
  color: #fff !important;
}

.content-header {
  padding-left: 260px;
}
</style>
