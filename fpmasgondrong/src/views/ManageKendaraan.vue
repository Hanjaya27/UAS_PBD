<template>
  <AdminLayout>
    <template #header></template>

    <h1 class="text-center my-4 judul-kelola">Kelola Kendaraan</h1>

    <!-- Tombol Tambah Kendaraan -->
    <div class="container mb-3 text-end">
      <button @click="$router.push('/admin/tambah-kendaraan')" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Kendaraan
      </button>
    </div>

    <!-- Statistik -->
    <div class="container mb-4">
      <div class="row">
        <div class="col-md-4 mb-3" v-for="stat in statistik" :key="stat.label">
          <div :class="`card text-white ${stat.bg}`">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h5 class="card-title">{{ stat.label }}</h5>
                  <h3>{{ stat.value }}</h3>
                </div>
                <i :class="`fas ${stat.icon} fa-2x`"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabel Kendaraan -->
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm w-100">
            <div class="card-header border-bottom-0">
              <h3 class="card-title"><i class="fas fa-list me-2"></i>Daftar Kendaraan</h3>
            </div>
            <div class="card-body px-3">
              <div class="table-responsive px-0">
                <table class="table table-hover align-middle mb-0 w-100">
                  <thead class="bg-light text-secondary text-uppercase small">
                    <tr>
                      <th>Gambar</th>
                      <th>Tipe</th>
                      <th>Jenis</th>
                      <th>Plat</th>
                      <th>Harga</th>
                      <th>Status</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="k in kendaraan" :key="k.id_kendaraan" class="border-bottom">
                      <td>
                        <img :src="getGambarUrl(k.gambar)" class="rounded" style="width: 90px;" />
                      </td>
                      <td>{{ k.tipe }}</td>
                      <td>{{ k.jenis }}</td>
                      <td>{{ k.plat_nomor }}</td>
                      <td>Rp {{ Number(k.harga_perhari).toLocaleString('id-ID') }}</td>
                      <td>
                        <span class="badge rounded-pill" :class="k.status.toLowerCase() === 'tersedia' ? 'bg-success' : 'bg-secondary'">
                          {{ k.status }}
                        </span>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning me-1" @click="$router.push(`/admin/edit-kendaraan/${k.id_kendaraan}`)">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" @click="hapusKendaraan(k.id_kendaraan)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr v-if="kendaraan.length === 0">
                      <td colspan="7" class="text-center text-muted py-3">Data kendaraan tidak tersedia</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/components/AdminLayout.vue';
import api from '@/api';

export default {
  components: { AdminLayout },
  data() {
    return {
      kendaraan: [],
      statistik: []
    };
  },
  mounted() {
    this.ambilDataKendaraan();
  },
  methods: {
    ambilDataKendaraan() {
      api.get('kendaraan')
        .then(response => {
          const result = Array.isArray(response.data) ? response.data : response.data.data;
          this.kendaraan = result;

          const total = this.kendaraan.length;
          const tersedia = this.kendaraan.filter(k => k.status.toLowerCase() === 'tersedia').length;
          const tidakTersedia = total - tersedia;

          this.statistik = [
            { label: 'Total Kendaraan', value: total, bg: 'bg-primary', icon: 'fa-car' },
            { label: 'Tersedia', value: tersedia, bg: 'bg-success', icon: 'fa-check-circle' },
            { label: 'Tidak Tersedia', value: tidakTersedia, bg: 'bg-secondary', icon: 'fa-times-circle' }
          ];
        })
        .catch(error => {
          console.error('Gagal ambil data:', error);
        });
    },
    getGambarUrl(filename) {
      return `http://localhost:8000/storage/kendaraan/${filename}`;
    },
    hapusKendaraan(id) {
      if (confirm("Apakah kamu yakin ingin menghapus kendaraan ini?")) {
        api.delete(`kendaraan/${id}`)
          .then(() => {
            this.kendaraan = this.kendaraan.filter(k => k.id_kendaraan !== id);
            this.ambilDataKendaraan();
          })
          .catch(err => {
            console.error('Gagal menghapus kendaraan:', err);
          });
      }
    }
  }
};
</script>

<style scoped>
.card {
  max-width: 1500px;
  margin-bottom: 20px;
}

.judul-kelola {
  font-size: 5.5rem;
  font-weight: bold;
  text-align: center;
  margin-bottom: 20px;
}

.table td, .table th {
  vertical-align: middle;
}

.card-title i {
  margin-right: 6px;
}

.badge {
  font-size: 0.8rem;
  padding: 0.4em 0.6em;
}
</style>
