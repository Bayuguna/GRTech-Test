<script setup lang="ts">
import { ref, onMounted, h } from "vue";
import axios from "axios";
import FormEmployee from "./FormEmployee/FormEmployee.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import CreateEmployee from "./FormEmployee/CreateEmployee.vue";
import EditEmployee from "./FormEmployee/EditEmployee.vue";
import Swal from "sweetalert2";
import { Toast } from "@/Components/Atoms/BToast.vue";

const employees = ref([]); // Data storage
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

// Fetch Employee Data
const fetchEmployees = async () => {
    try {
        const response = await axios.get("/employees/data");
        employees.value = response.data.data;
    } catch (error) {
        console.error("Error fetching employees:", error);
    } finally {
        loading.value = false;
    }
};

// Call function when component loads
onMounted(fetchEmployees);

// Delete Employee Data
const deleteEmployee = async (employee_uuid: string) => {
    try {
        await axios.delete("/employees/delete/" + employee_uuid);
        fetchEmployees();
    } catch (error) {
        console.error("Error deleting employee:", error);
    }
};
const showDeleteAlert = (employee_uuid: string) => {
    Swal.fire({
        title: "Delete!",
        text: "Are you sure you want to delete this company?",
        icon: "warning",
        confirmButtonText: "Yes, delete it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        if (response.isConfirmed) {
            deleteEmployee(employee_uuid)
                .then(() => {
                    fetchEmployees();
                    toast.success("Employee updated successfully!");
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
        title: "Full Name",
        dataIndex: "full_name",
        key: "full_name",
        width: 200,
    },
    {
        title: "Email",
        dataIndex: "email",
        key: "email",
        width: 250,
    },
    {
        title: "Phone",
        dataIndex: "phone",
        key: "phone",
        width: 150,
    },
    {
        title: "Company",
        dataIndex: "company",
        key: "company",
        width: 200,
        customRender: ({ record }: any) => record.company?.name || "N/A",
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
            :label="'Add New Employee'"
            :suffix-icon="'plus'"
            @click="showAddModal"
        />
    </div>
    <a-table
        :columns="columns"
        :data-source="employees"
        :loading="loading"
        bordered
        row-key="uuid"
        pagination
    />

    <div v-if="editModal">
        <a-modal v-model:open="editModal" title="Edit Employee" :footer="null">
            <EditEmployee :uuid="employeeUUID" />
        </a-modal>
    </div>

    <div v-if="addModal">
        <a-modal v-model:open="addModal" title="Create Employee" :footer="null">
            <CreateEmployee />
        </a-modal>
    </div>
</template>
