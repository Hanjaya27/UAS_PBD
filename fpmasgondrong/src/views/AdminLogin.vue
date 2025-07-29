<template>
  <div class="container">
    <div class="login-box">
      <h4 class="text-center mb-4">Login Admin</h4>

      <form @submit.prevent="login">
        <div class="mb-3">
          <label>Username</label>
          <input v-model="username" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input v-model="password" type="password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-green w-100">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminLogin',
  methods: {
  async login() {
    try {
      const response = await fetch('http://localhost:8000/api/admin/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          username: this.username,
          password: this.password
        })
      });

      if (!response.ok) throw new Error('Login gagal');
      const data = await response.json();

      // Simpan status login & data admin
      localStorage.setItem('isLoggedIn', 'true');
      localStorage.setItem('admin', JSON.stringify(data.admin));
      window.dispatchEvent(new Event('user-login-changed'));

      // Redirect ke dashboard admin
      this.$router.push('/admin/dashboard');
    } catch (error) {
      alert('Username atau password salah');
    }
  }
}
}
</script>
