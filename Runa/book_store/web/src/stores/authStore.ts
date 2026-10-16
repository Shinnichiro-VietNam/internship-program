import { create } from "zustand";

type AuthState = {
    token: string | null;
    setToken: (token: string | null) => void;
};

export const useAuthStore = create<AuthState>((set) => ({
    token: localStorage.getItem("token"),
    setToken: (token) => {
    if (token) localStorage.setItem("token", token);
    else localStorage.removeItem("token");
    set({ token });
    },
}));