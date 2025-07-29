<template>
  <AdminLayout>
    <template #header></template>
    <h1 class="text-center my-4 judul-kelola">Kelola Pengguna</h1>

    <!-- Statistik Ringkasan -->
    <div class="row mb-4 text-center">
      <div class="col-md-3" v-for="item in summaryCards" :key="item.title">
        <div class="card shadow-sm p-3">
          <h6>{{ item.title }}</h6>
          <h4 class="text-primary">{{ item.value }}</h4>
        </div>
      </div>
    </div>

    <!-- Tombol Tambah -->
    <div class="container mb-3 text-end">
      <button class="btn btn-primary" @click="tambahPengguna">
        <i class="fas fa-plus"></i> Tambah Pengguna
      </button>
    </div>

    <!-- Tabel Pengguna -->
    <div class="container">
      <div class="card shadow-sm">
        <div class="card-body table-responsive">
          <table class="table table-hover align-middle">
            <thead class="bg-light text-secondary text-uppercase small">
              <tr>
                <th>Nama</th>
                <th>Email</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="u in pengguna" :key="u.id_user">
                <td>{{ u.nama }}</td>
                <td>{{ u.email }}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-outline-primary me-2" @click="editPengguna(u)">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <button class="btn btn-sm btn-outline-danger" @click="hapusPengguna(u.id_user)">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </td>
              </tr>
              <tr v-if="pengguna.length === 0">
                <td colspan="3" class="text-center text-muted py-3">Data pengguna tidak tersedia</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="penggunaModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEdit ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h5>
            <button type="button" class="btn-close" @click="tutupModal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="simpanPengguna">
              <div class="mb-3">
                <label>Nama</label>
                <input v-model="form.nama" type="text" class="form-control" required />
              </div>
              <div class="mb-3">
                <label>Email</label>
                <input v-model="form.email" type="email" class="form-control" required />
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input v-model="form.password" type="password" class="form-control" :required="!isEdit" />
              </div>
              <div class="text-end">
                <button type="button" class="btn btn-secondary" @click="tutupModal">Batal</button>
                <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Simpan' }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import * as bootstrap from 'bootstrap';
import api from '@/api';
import AdminLayout from '@/components/AdminLayout.vue';
import Swal from 'sweetalert2';

export default {
  components: { AdminLayout },
  data() {
    return {
      pengguna: [],
      summaryCards: [],
      form: {
        id_user: null,
        nama: '',
        email: '',
        password: ''
      },
      isEdit: false,
      modalInstance: null
    };
  },
  mounted() {
    this.getPengguna();
    this.modalInstance = new bootstrap.Modal(document.getElementById('penggunaModal'));
  },
  methods: {
    async getPengguna() {
      try {
        const res = await api.get('/pengguna');
        this.pengguna = res.data;
        this.summaryCards = [
          { title: 'Total Pengguna', value: this.pengguna.length }
        ];
      } catch (err) {
        console.error('Gagal mengambil data:', err);
        Swal.fire('Error!', 'Gagal mengambil data pengguna.', 'error');
      }
    },

    tambahPengguna() {
      this.isEdit = false;
      this.form = { id_user: null, nama: '', email: '', password: '' };
      this.modalInstance.show();
    },

    editPengguna(u) {
      this.isEdit = true;
      this.form = { id_user: u.id_user, nama: u.nama, email: u.email, password: '' };
      this.modalInstance.show();
    },

    tutupModal() {
      this.modalInstance.hide();
    },

    async simpanPengguna() {
      try {
        if (this.isEdit) {
          const res = await api.put(`/pengguna/${this.form.id_user}`, this.form);
          if (res.data.success) {
            Swal.fire('Berhasil!', 'Pengguna berhasil diperbarui.', 'success');
            this.tutupModal();
            this.getPengguna();
          } else {
            Swal.fire('Gagal!', res.data.message || 'Gagal update pengguna.', 'error');
          }
        } else {
          if (!this.form.password) {
            Swal.fire('Peringatan!', 'Password wajib diisi!', 'warning');
            return;
          }
          const res = await api.post('/pengguna', this.form);
          if (res.data.success) {
            Swal.fire('Berhasil!', 'Pengguna berhasil ditambahkan.', 'success');
            this.tutupModal();
            this.getPengguna();
          } else {
            Swal.fire('Gagal!', res.data.message || 'Gagal tambah pengguna.', 'error');
          }
        }
      } catch (err) {
        console.error('Error simpan:', err);
        Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan pengguna.', 'error');
      }
    },

    async hapusPengguna(id) {
      const konfirmasi = await Swal.fire({
        title: 'Yakin ingin menghapus pengguna ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      });

      if (konfirmasi.isConfirmed) {
        try {
          const res = await api.delete(`/pengguna/${id}`);
          if (res.data.success) {
            Swal.fire('Berhasil!', 'Pengguna berhasil dihapus.', 'success');
            this.getPengguna();
          } else {
            Swal.fire('Gagal!', res.data.message || 'Gagal hapus pengguna.', 'error');
          }
        } catch (err) {
          console.error('Gagal hapus:', err);
          Swal.fire('Error!', 'Terjadi kesalahan saat menghapus pengguna.', 'error');
        }
      }
    }
  }
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

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

th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
}

th {
  background-color: #3498db;
  color: white;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: #f1f1f1;
}

button {
  background-color: #3498db;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2980b9;
}

.card {
  max-width: 1500px;
  margin-bottom: 20px;
}

.modal-backdrop {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-box {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
}
</style>
