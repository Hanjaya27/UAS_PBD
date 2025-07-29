import axios from 'axios';

export default axios.create({
  baseURL: 'http://localhost:8000/api', // Pastikan ini benar sesuai backend Laravel kamu
  headers: {
    'Content-Type': 'application/json'
  }
});
