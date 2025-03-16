<script setup lang="ts">
import { ref, onMounted, h } from "vue";
import axios from "axios";
import BButton from "@/Components/Atoms/BButton.vue";
import Swal from "sweetalert2";
import { Toast } from "@/Components/Atoms/BToast.vue";
import EditCompany from "./FormCompany/EditCompany.vue";
import CreateCompany from "./FormCompany/CreateCompany.vue";

const companies = ref([]); // Data storage
const loading = ref(true); // Loading state
const editModal = ref<boolean>(false);
const addModal = ref<boolean>(false);
const employeeUUID = ref<string>("");
const toast = new Toast();

const showEditModal = (employee_uuid: string) => {
    editModal.value = true;
    employeeUUID.value = employee_uuid;
};

const showAddModal = () => {
    addModal.value = true;
};

// Fetch Company Data
const fetchCompanies = async () => {
    try {
        const response = await axios.get("/companies/data");
        companies.value = response.data.data;
    } catch (error) {
        console.error("Error fetching companies:", error);
    } finally {
        loading.value = false;
    }
};

// Call function when component loads
onMounted(fetchCompanies);

// Delete Company Data
const deleteCompany = async (employee_uuid: string) => {
    try {
        await axios.delete("/companies/delete/" + employee_uuid);
        fetchCompanies();
    } catch (error) {
        console.error("Error deleting employee:", error);
    }
};
const showDeleteAlert = (employee_uuid: string) => {
    Swal.fire({
        title: "Danger!",
        text: "Are you sure you want to delete this employee?",
        icon: "warning",
        confirmButtonText: "Yes, delete it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        if (response.isConfirmed) {
            deleteCompany(employee_uuid)
                .then(() => {
                    fetchCompanies();
                    toast.success("Company updated successfully!");
                })
                .catch((error) => {
                    toast.errors("Error updating employee!");
                })
                .finally(() => {
                    loading.value = false;
                });
        } else {
            loading.value = false;
        }
    });
};

// Table Columns
const columns = [
    {
        title: "No",
        dataIndex: "DT_RowIndex",
        key: "DT_RowIndex",
        width: 30,
    },
    {
        title: "Company",
        dataIndex: "name",
        key: "name",
        width: 200,
        customRender: ({ record }: any) => h("div", { innerHTML: record.name }),
    },
    {
        title: "Contact",
        dataIndex: "contact",
        key: "contact",
        width: 250,
        customRender: ({ record }: any) =>
            h("div", { innerHTML: record.contact }),
    },
    {
        title: "Address",
        dataIndex: "address",
        key: "address",
        width: 300,
    },
    {
        title: "Status",
        dataIndex: "status",
        key: "status",
        width: 120,
        customRender: ({ record }: any) =>
            h("div", { innerHTML: record.status }),
    },
    {
        title: "Actions",
        dataIndex: "action",
        key: "action",
        width: 150,
        customRender: ({ record }: any) => [
            h(
                "a",
                {
                    onClick: () => showEditModal(record.uuid),
                },
                "Edit"
            ),
            h("span", { style: { margin: "0 5px" } }, "|"),
            h(
                "a",
                {
                    onClick: () => showDeleteAlert(record.uuid),
                    style: {
                        cursor: "pointer",
                        color: "red",
                        // textDecoration: "underline",
                    },
                },
                "Delete"
            ),
        ],
    },
];
</script>

<template>
    <div class="flex justify-end pb-4">
        <BButton
            color="success-outline"
            :label="'Add New Company'"
            :suffix-icon="'plus'"
            @click="showAddModal"
        />
    </div>
    <a-table
        :columns="columns"
        :data-source="companies"
        :loading="loading"
        bordered
        row-key="uuid"
        pagination
    />

    <div v-if="editModal">
        <a-modal v-model:open="editModal" title="Edit Company" :footer="null">
            <EditCompany :uuid="employeeUUID" />
        </a-modal>
    </div>

    <div v-if="addModal">
        <a-modal v-model:open="addModal" title="Create Company" :footer="null">
            <CreateCompany />
        </a-modal>
    </div>
</template>
