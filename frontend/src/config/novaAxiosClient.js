import axios from "axios";

const novaAxiosClient = axios.create({
  baseURL: 'http://localhost:8000/api'
})

novaAxiosClient.interceptors.request.use((config) => {
  const token = localStorage.getItem('ACCESS_TOKEN');
  config.headers.Authorization = `Bearer ${token}`
  return config;
})

novaAxiosClient.interceptors.response.use((response) => {
  return response
}, (error) => {
  
  const {response} = error;
  if (response.status === 401) {
    localStorage.removeItem('ACCESS_TOKEN')
    // window.location.reload();
  } else if (response.status === 404) {
    //Show not found
  }

  throw error;
})

export default novaAxiosClient