import axios from "axios";
import { useAuthStore } from "../stores/authStore";

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    "Content-Type": "application/json",
  },
  timeout: 10000,
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      const url = error.config?.url ?? "";
      const isAuthForm = url.includes("/login") || url.includes("/register");
      useAuthStore.getState().setToken(null);
      useAuthStore.getState().setUser(null);

      if (!isAuthForm) {
        window.location.href = "/login";
      }
    }
    return Promise.reject(error);
  },
);

api.interceptors.request.use((config) => {
  const token = useAuthStore.getState().token;
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
