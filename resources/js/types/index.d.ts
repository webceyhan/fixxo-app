export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    role: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

export type RouterLink = {
    label: string;
    icon?: string;
    route: string;
    params?: Record<string, any>;
};
