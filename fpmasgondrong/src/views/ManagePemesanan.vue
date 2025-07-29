<template>
  <AdminLayout>
    <template #header></template>

    <h1 class="text-center my-4 judul-kelola">Kelola Pemesanan</h1>

    <!-- Chart -->
    <div class="container row mx-auto mb-4">
      <div class="col-md-6 mb-4">
        <h5 class="text-center">Jumlah Pemesanan per Hari</h5>
        <div style="height: 250px;">
          <Line v-if="pemesanan.length > 0" :data="lineChartData" :options="chartOptions" />
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <h5 class="text-center">Status Pemesanan</h5>
        <div style="height: 250px;">
          <Doughnut v-if="pemesanan.length > 0" :data="doughnutData" :options="chartOptions" />
        </div>
      </div>
    </div>

    <!-- Filter -->
    <div class="container text-center mb-3">
      <button
        v-for="status in ['semua', 'diproses', 'selesai', 'batal']"
        :key="status"
        :class="['btn', 'me-2', filterStatus === status ? 'btn-primary' : 'btn-outline-primary']"
        @click="filterStatus = status"
      >
        {{ status.toUpperCase() }}
      </button>
    </div>

    <!-- Tabel -->
    <div class="container">
      <div class="card shadow-sm w-100">
        <div class="card-header border-bottom-0">
          <h3 class="card-title"><i class="fas fa-list me-2"></i>Daftar Pemesanan</h3>
        </div>
        <div class="card-body px-3 table-responsive">
          <table class="table table-hover align-middle mb-0 w-100">
            <thead class="bg-light text-secondary text-uppercase small">
              <tr>
                <th>Nama User</th>
                <th>Kendaraan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Ubah Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in pemesananTersaring" :key="item.id_pemesanan">
                <td>{{ item.nama_user }}</td>
                <td>{{ item.nama_kendaraan }}</td>
                <td>{{ item.tgl_mulai }} - {{ item.tgl_selesai }}</td>
                <td>
                  <span class="badge rounded-pill"
                        :class="{
                          'bg-warning': item.status === 'diproses',
                          'bg-success': item.status === 'selesai',
                          'bg-danger': item.status === 'batal'
                        }">
                    {{ item.status }}
                  </span>
                </td>
                <td>
                  <select class="form-select form-select-sm"
                          v-model="item.status"
                          @change="updateStatus(item.id_pemesanan, item.status)">
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="batal">Batal</option>
                  </select>
                </td>
              </tr>
              <tr v-if="pemesananTersaring.length === 0">
                <td colspan="5" class="text-center text-muted py-3">Data pemesanan tidak tersedia</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/components/AdminLayout.vue';
import { Line, Doughnut } from 'vue-chartjs';
import api from '@/api';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  ArcElement
} from 'chart.js';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  ArcElement
);

export default {
  components: {
    AdminLayout,
    Line,
    Doughnut
  },
  data() {
    return {
      pemesanan: [],
      filterStatus: 'semua',
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false
      }
    };
  },
  computed: {
    pemesananTersaring() {
      if (this.filterStatus === 'semua') {
        return this.pemesanan;
      }
      return this.pemesanan.filter(p => p.status === this.filterStatus);
    },
    lineChartData() {
      const countPerDate = {};
      this.pemesanan.forEach(item => {
        const date = item.tgl_mulai;
        countPerDate[date] = (countPerDate[date] || 0) + 1;
      });
      return {
        labels: Object.keys(countPerDate),
        datasets: [{
          label: 'Pemesanan per Tanggal',
          data: Object.values(countPerDate),
          borderColor: '#3498db',
          backgroundColor: '#3498db',
          tension: 0.3,
          fill: false
        }]
      };
    },
    doughnutData() {
      const count = { diproses: 0, selesai: 0, batal: 0 };
      this.pemesanan.forEach(item => {
        if (count[item.status] !== undefined) {
          count[item.status]++;
        }
      });
      return {
        labels: ['Diproses', 'Selesai', 'Batal'],
        datasets: [{
          data: [count.diproses, count.selesai, count.batal],
          backgroundColor: ['#f1c40f', '#2ecc71', '#e74c3c']
        }]
      };
    }
  },
  mounted() {
    api.get('pemesanan')
      .then(res => {
        this.pemesanan = res.data;
      })
      .catch(err => {
        console.error('Gagal memuat data pemesanan:', err);
      });
  },
  methods: {
    updateStatus(id_pemesanan, status) {
      api.post('pemesanan/update_status', {
        id_pemesanan,
        status
      }).then(() => {
        alert('Status diperbarui!');
      }).catch(err => {
        console.error('Gagal memperbarui status:', err);
      });
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
  font-size: 2.5rem;
  font-weight: bold;
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
