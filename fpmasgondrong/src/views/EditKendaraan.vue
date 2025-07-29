<template>
  <NavbarAdmin />
  <div>
    <h1>EDIT KENDARAAN</h1>

    <div v-if="form.gambar">
      <img :src="getGambarUrl(form.gambar)" alt="Gambar Kendaraan" class="kendaraan-img" />
    </div>

    <form @submit.prevent="simpanPerubahan">
      <div class="form-group">
        <label>Tipe:</label>
        <input v-model="form.tipe" type="text" required />
      </div>

      <div class="form-group">
        <label>Jenis:</label>
        <input v-model="form.jenis" type="text" required />
      </div>

      <div class="form-group">
        <label>Plat Nomor:</label>
        <input v-model="form.plat_nomor" type="text" required />
      </div>

      <div class="form-group">
        <label>Harga Per Hari:</label>
        <input v-model="form.harga_perhari" type="number" required />
      </div>

      <div class="form-group">
        <label>Status:</label>
        <select v-model="form.status">
          <option value="tersedia">Tersedia</option>
          <option value="disewa">Disewa</option>
        </select>
      </div>

      <button type="submit">Simpan Perubahan</button>
    </form>
  </div>
</template>

<script>
import api from '@/api';
import NavbarAdmin from '@/components/NavbarAdmin.vue';

export default {
  components: { NavbarAdmin },
  data() {
    return {
      form: {
        tipe: '',
        jenis: '',
        plat_nomor: '',
        harga_perhari: 0,
        status: 'tersedia',
        gambar: ''
      }
    };
  },
  mounted() {
    const id = this.$route.params.id;
    api.get(`kendaraan/${id}`)
      .then(res => {
        if (res.data.status === 'success') {
          this.form = res.data.data;
        } else {
          alert('Data tidak ditemukan');
        }
      })
      .catch(err => {
        console.error('Gagal mengambil data kendaraan:', err);
      });
  },
  methods: {
    simpanPerubahan() {
      const id = this.$route.params.id;
      api.put(`kendaraan/${id}`, this.form)
        .then(() => {
          alert('Data kendaraan berhasil diperbarui!');
          this.$router.push('/admin/kendaraan');
        })
        .catch(err => {
          console.error('Gagal menyimpan perubahan:', err);
        });
    },
    getGambarUrl(filename) {
      return `http://localhost:8000/storage/kendaraan/${filename}`;
    }
  }
};
</script>


<style scoped>
h1 {
  text-align: center;
  font-size: 32px;
  color: #2c3e50;
  margin-bottom: 30px;
  background-color: #f7f9fb;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

form {
  max-width: 600px;
  margin: auto;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
}

input, select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  background-color: #3498db;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #2980b9;
}

.kendaraan-img {
  width: 200px;
  height: auto;
  object-fit: contain;
  display: block;
  margin: 0 auto 20px auto;
  border: 1px solid #ccc;
  border-radius: 8px;
}
</style>
