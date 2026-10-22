import api from '../plugins/axios';
import type { ApiSuccess } from '../types/api';

type TokenData = {
    token: string;
    token_type: string;
};

type UserData = {
    id: number;
    name: string;
    email: string;
};

export class Auth {
    static async register(body: {
    name: string;
    email: string;
    password: string;
    }): Promise<ApiSuccess<TokenData>> {
    const response = await api.post<ApiSuccess<TokenData>>('/register', body);
    return response.data;
    }

    static async login(body: {
    email: string;
    password: string;
    }): Promise<ApiSuccess<TokenData>> {
    const response = await api.post<ApiSuccess<TokenData>>('/login', body);
    return response.data;
    }

    static async logout(): Promise<void> {
    await api.post('/logout');
    }

    static async me(): Promise<ApiSuccess<UserData>> {
    const response = await api.get<ApiSuccess<UserData>>('/user');
    return response.data;
    }
}