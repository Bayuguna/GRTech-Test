<script setup lang="ts">
import BTextfiled from "@/Components/Atoms/BTextfield.vue";
import BSwitch from "@/Components/Atoms/BSwitch.vue";
import { UserData } from "@/types/user";
import BSelect from "@/Components/Atoms/BSelect.vue";
import axios from "axios";
import { h, onMounted, ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import BButton from "@/Components/Atoms/BButton.vue";

const toast = new Toast();

const props = defineProps<{
    uuid: string;
}>();

const user_roles = ref([]);
const loading = ref(false);

const fetchUserRole = async () => {
    const url = route("user_role.data", { user_uuid: props.uuid });
    const response = await axios.get(url);
    user_roles.value = response.data.data;
    console.log(response.data);
};

const deleteUserRole = async (uuid: string) => {
    const url = route("user_role.delete", {
        uuid: uuid,
    });
    await axios
        .delete(url)
        .then(() => {
            fetchUserRole();
            toast.success("Role deleted successfully!");
        })
        .catch((error) => {
            toast.errors("Error delete role!");
        })
        .finally(() => {
            loading.value = false;
        });
};

onMounted(fetchUserRole);

// Table Columns
const columns = [
    {
        title: "No",
        dataIndex: "DT_RowIndex",
        key: "DT_RowIndex",
        width: 30,
    },
    {
        title: "Role",
        dataIndex: "role",
        key: "role",
        width: 200,
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
                    onClick: () => {
                        deleteUserRole(record.uuid);
                    },
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
    <a-table
        :columns="columns"
        :data-source="user_roles"
        :loading="loading"
        bordered
        row-key="uuid"
        pagination
    />
</template>
