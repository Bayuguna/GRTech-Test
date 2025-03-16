export interface CompanyData {
    uuid: string;
    name: string;
    email: string;
    phone: string;
    address: string;
    logo: File | null;
    website: string;
    status: "ACTIVE" | "INACTIVE";
    created_at?: string;
}
