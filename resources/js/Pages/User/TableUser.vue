<script setup lang="ts">
import { ref, onMounted, h } from "vue";
import axios from "axios";
import FormUser from "./FormUser/FormUser.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import Swal from "sweetalert2";
import { Toast } from "@/Components/Atoms/BToast.vue";
import EditUser from "./FormUser/EditUser.vue";
import CreateUser from "./FormUser/CreateUser.vue";
import RoleUser from "./FormUserRole/EditUserRole.vue";

const users = ref([]); // Data storage
const loading = ref(true); // Loading state
const editModal = ref<boolean>(false);
const addModal = ref<boolean>(false);
const roleModal = ref<boolean>(false);
const userUUID = ref<string>("");
const toast = new Toast();

const showEditModal = (user_uuid: string) => {
    editModal.value = true;
    userUUID.value = user_uuid;
};

const showAddModal = () => {
    addModal.value = true;
};

const showRoleModal = (user_uuid: string) => {
    roleModal.value = true;
    userUUID.value = user_uuid;
};

// Fetch User Data
const fetchUsers = async () => {
    try {
        const response = await axios.get(route("user.data"));
        users.value = response.data.data;
    } catch (error) {
        console.error("Error fetching users:", error);
    } finally {
        loading.value = false;
    }
};

// Call function when component loads
onMounted(fetchUsers);

// Table Columns
const columns = [
    {
        title: "No",
        dataIndex: "DT_RowIndex",
        key: "DT_RowIndex",
        width: 30,
    },
    {
        title: "Name",
        dataIndex: "name",
        key: "name",
        width: 200,
    },
    {
        title: "Email",
        dataIndex: "email",
        key: "email",
        width: 250,
    },
    {
        title: "Created By",
        dataIndex: "created_by",
        key: "created_by",
        width: 200,
    },
    {
        title: "Role",
        dataIndex: "user_roles",
        key: "user_roles",
        width: 200,
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
                    onClick: () => {
                        showRoleModal(record.uuid);
                    },
                },
                "Role"
            ),
            // h("span", { style: { margin: "0 5px" } }, "|"),
            // h(
            //     "a",
            //     {
            //         onClick: () => showDeleteAlert(record.uuid),
            //         style: {
            //             cursor: "pointer",
            //             color: "red",
            //             // textDecoration: "underline",
            //         },
            //     },
            //     "Delete"
            // ),
        ],
    },
];
</script>

<template>
    <div class="flex justify-end pb-4">
        <BButton
            color="success-outline"
            :label="'Add New User'"
            :suffix-icon="'plus'"
            @click="showAddModal"
        />
    </div>
    <a-table
        :columns="columns"
        :data-source="users"
        :loading="loading"
        bordered
        row-key="uuid"
        pagination
    />

    <div v-if="editModal">
        <a-modal v-model:open="editModal" title="Edit User" :footer="null">
            <EditUser :uuid="userUUID" />
        </a-modal>
    </div>

    <div v-if="addModal">
        <a-modal v-model:open="addModal" title="Create User" :footer="null">
            <CreateUser />
        </a-modal>
    </div>

    <div v-if="roleModal">
        <a-modal v-model:open="roleModal" title="Edit User Role" :footer="null">
            <RoleUser :uuid="userUUID" />
        </a-modal>
    </div>
</template>
