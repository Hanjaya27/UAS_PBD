<template>
  <AdminLayout>
    <template #header></template>
    <h1 class="text-center my-4 judul-kelola">Kelola Admin</h1>

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
      <button class="btn btn-primary" @click="tambahAdmin">
        <i class="fas fa-plus"></i> Tambah Admin
      </button>
    </div>

    <!-- Tabel Admin -->
    <div class="container">
      <div class="card shadow-sm">
        <div class="card-body table-responsive">
          <table class="table table-hover align-middle">
            <thead class="bg-light text-secondary text-uppercase small">
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="a in admins" :key="a.id_admin">
                <td>{{ a.id_admin }}</td>
                <td>{{ a.username }}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-outline-primary me-2" @click="editAdmin(a)">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <button class="btn btn-sm btn-outline-danger" @click="hapusAdmin(a.id_admin)">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </td>
              </tr>
              <tr v-if="admins.length === 0">
                <td colspan="3" class="text-center text-muted py-3">Data admin tidak tersedia</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="adminModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEdit ? 'Edit Admin' : 'Tambah Admin' }}</h5>
            <button type="button" class="btn-close" @click="tutupModal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="simpanAdmin">
              <div class="mb-3">
                <label>Username</label>
                <input v-model="form.username" type="text" class="form-control" required />
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
import Swal from 'sweetalert2';
import AdminLayout from '@/components/AdminLayout.vue';

export default {
  components: { AdminLayout },
  data() {
    return {
      admins: [],
      summaryCards: [],
      form: { id_admin: null, username: '', password: '' },
      isEdit: false,
      modalInstance: null
    };
  },
  mounted() {
    this.getAdmins();
    this.modalInstance = new bootstrap.Modal(document.getElementById('adminModal'));
  },
  methods: {
    async getAdmins() {
      try {
        const res = await api.get('/admin');
        this.admins = res.data;
        this.summaryCards = [{ title: 'Total Admin', value: this.admins.length }];
      } catch (err) {
        console.error('Gagal mengambil data:', err);
        Swal.fire('Error!', 'Gagal mengambil data admin.', 'error');
      }
    },

    tambahAdmin() {
      this.isEdit = false;
      this.form = { id_admin: null, username: '', password: '' };
      this.modalInstance.show();
    },

    editAdmin(a) {
      this.isEdit = true;
      this.form = { id_admin: a.id_admin, username: a.username, password: '' };
      this.modalInstance.show();
    },

    tutupModal() {
      this.modalInstance.hide();
    },

    async simpanAdmin() {
      try {
        let res;
        if (this.isEdit) {
          res = await api.put(`/admin/${this.form.id_admin}`, this.form);
        } else {
          if (!this.form.password) {
            Swal.fire('Peringatan!', 'Password wajib diisi!', 'warning');
            return;
          }
          res = await api.post('/admin', this.form);
        }

        const isSuccess =
          res.data.success === true ||
          res.data.status === 'success' ||
          (res.data.message && res.data.message.toLowerCase().includes('berhasil'));

        if (isSuccess) {
          Swal.fire(
            'Berhasil!',
            this.isEdit ? 'Admin berhasil diperbarui.' : 'Admin berhasil ditambahkan.',
            'success'
          );
          this.tutupModal();
          this.getAdmins();
        } else {
          Swal.fire(
            'Gagal!',
            res.data.message || (this.isEdit ? 'Gagal memperbarui admin.' : 'Gagal menambahkan admin.'),
            'error'
          );
        }
      } catch (err) {
        console.error('Error simpan:', err);
        Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan admin.', 'error');
      }
    },

    async hapusAdmin(id) {
      const konfirmasi = await Swal.fire({
        title: 'Yakin ingin menghapus admin ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      });

      if (konfirmasi.isConfirmed) {
        try {
          const res = await api.delete(`/admin/${id}`);
          const isSuccess =
            res.data.success === true ||
            res.data.status === 'success' ||
            (res.data.message && res.data.message.toLowerCase().includes('berhasil'));

          if (isSuccess) {
            Swal.fire('Berhasil!', res.data.message || 'Admin berhasil dihapus.', 'success');
            this.getAdmins();
          } else {
            Swal.fire('Gagal!', res.data.message || 'Gagal hapus admin.', 'error');
          }
        } catch (err) {
          console.error('Gagal hapus:', err);
          Swal.fire('Error!', 'Terjadi kesalahan saat menghapus admin.', 'error');
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
