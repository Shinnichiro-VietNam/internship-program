import axios from 'axios';
import { useAuthStore } from '../stores/authStore';

export const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
    'Content-Type': 'application/json',
    },
    timeout: 10000,
});

api.interceptors.request.use((config) => {
    const token = useAuthStore.getState().token;
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

api.interceptors.response.use((response) => response,
(error) =>
{
    if (error.response?.status === 401) {
        useAuthStore.getState().setToken(null);
    }
    return Promise.reject(error);
},
);

export default api;