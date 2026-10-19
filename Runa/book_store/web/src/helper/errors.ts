import axios from 'axios';
import type { ApiErrorBody } from '../types/api';

export function parseApiError(error: unknown): {
    message: string;
    fields?: Record<string, string[]>;
} {
    if (axios.isAxiosError(error)) {
        const data = error.response?.data as ApiErrorBody | undefined;

        if (data?.message) {
            return {
                message: data.message,
                fields: data.errors?.fields,
            };
        }
    }

    return {
        message: 'Something wrong.',
    };
}