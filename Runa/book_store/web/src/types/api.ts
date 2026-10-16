export type ApiSuccess<T> = {
    status: number;
    message: string | null;
    data: T;
};

export type ApiErrorBody = {
    status: number;
    message: string | null;
    errors?: {
    code?: string;
    fields?: Record<string, string[]>;
    };
};