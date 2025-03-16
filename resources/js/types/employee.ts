export interface EmployeeData {
    uuid: string;
    first_name: string;
    last_name: string;
    email: string;
    phone: string;
    status: "ACTIVE" | "INACTIVE";
    company_uuid: string;
    created_at?: string;
}
