import api from '../plugins/axios';

export class BaseModel {
    static baseUrl = "";

    static async index<T>(params?: Record<string, any>): Promise<T> {
        const response = await api.get<T>(`/${this.baseUrl}`, { params });
        return response.data;
    }

    static async show<T>(id: number | string): Promise<T> {
        const response = await api.get<T>(`/${this.baseUrl}/${id}`);
        return response.data;
    }

    static async store<T>(data: any): Promise<T> {
        const response = await api.post<T>(`/${this.baseUrl}`, data);
        return response.data;
    }

    static async update<T>(id: number | string, data: any): Promise<T> {
        const response = await api.put<T>(`/${this.baseUrl}/${id}`, data);
        return response.data;
    }

    static async destroy<T>(id: number | string): Promise<T> {
        const response = await api.delete<T>(`/${this.baseUrl}/${id}`);
        return response.data;
    }
}