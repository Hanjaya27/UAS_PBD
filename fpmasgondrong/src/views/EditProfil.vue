<template>
  <div class="container mt-5">
    <div class="login-box">
      <h4 class="text-center mb-4">Edit Profil Pembeli</h4>
      <form @submit.prevent="submitForm">
        <div class="mb-3" v-for="(field, index) in fields" :key="index">
          <label>{{ field.label }}</label>
          <component :is="field.type === 'textarea' ? 'textarea' : 'input'"
                     class="form-control"
                     :type="field.inputType"
                     v-model="form[field.model]"
                     :rows="field.rows || null" />
        </div>
        <button type="submit" class="btn btn-green w-100">Simpan Perubahan</button>
      </form>
    </div>
  </div>
</template>

<script>
import api from '@/api';

export default {
  name: 'EditProfilPage',
  data() {
    return {
      form: {
        nama: '',
        email: '',
        alamat: '',
        no_hp: '',
        password: ''
      },
      fields: [
        { label: 'Nama', model: 'nama', inputType: 'text', type: 'input' },
        { label: 'Email', model: 'email', inputType: 'email', type: 'input' },
        { label: 'Alamat', model: 'alamat', inputType: '', type: 'textarea', rows: 3 },
        { label: 'No HP', model: 'no_hp', inputType: 'text', type: 'input' },
        { label: 'Password Baru (kosongkan jika tidak ingin ubah)', model: 'password', inputType: 'password', type: 'input' }
      ]
    };
  },
  mounted() {
    const userId = localStorage.getItem('user_id');
    if (!userId) return;

    api.get(`pengguna/${userId}`)
      .then(res => {
        this.form = {
          nama: res.data.nama,
          email: res.data.email,
          alamat: res.data.alamat,
          no_hp: res.data.no_hp,
          password: '' // kosongkan agar tidak langsung terganti
        };
      })
      .catch(err => {
        console.error('Gagal memuat data profil:', err);
      });
  },
  methods: {
    submitForm() {
      const userId = localStorage.getItem('user_id');
      if (!userId) {
        alert('User tidak ditemukan.');
        return;
      }

      api.post(`pengguna/${userId}`, this.form)
        .then(() => {
          alert('Profil berhasil diperbarui!');
          this.$router.push('/profil');
        })
        .catch(error => {
          console.error('Gagal update profil:', error);
          alert('Terjadi kesalahan saat menyimpan.');
        });
    }
  }
};
</script>

<style scoped>
.login-box {
  max-width: 500px;
  margin: auto;
  background: #f8f9fa;
  padding: 30px;
  border-radius: 8px;
}
</style>
