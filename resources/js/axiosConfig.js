

import axios from 'axios';

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'; 

axios.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token'); // Obtenha o token armazenado
    if (token) {
      config.headers.Authorization = `Bearer ${token}`; // Adicione o token ao cabeçalho da solicitação
    }
    return config;
  },
  error => Promise.reject(error)
);

export default axios;
