export interface UserData {
    uuid: string;
    name: string;
    email: string;
    password: string | null;
    role_uuid: string[];
    status: "ACTIVE" | "INACTIVE";
    created_at?: string;
    created_by?: string;
}
