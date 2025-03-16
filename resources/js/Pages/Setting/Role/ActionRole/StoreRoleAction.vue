<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { RoleData } from "@/types/role";

const toast = new Toast();
const loading = ref(false); // Loading state

const data = defineProps<{
    form: RoleData;
}>();

const updateRole = async () => {
    return await axios.post("/settings/roles/store", data.form);
};

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const showAlert = () => {
    Swal.fire({
        title: "Save Data!",
        text: "Are you sure you want to save this data?",
        icon: "question",
        confirmButtonText: "OK",
        showCancelButton: true,
        cancelButtonText: "Cancel",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            updateRole()
                .then(() => {
                    toast.success("Role created successfully!");
                    window.location.href = route("setting.role.index");
                })
                .catch((error) => {
                    toast.errors(error.message);
                    if (error.response?.data?.errors) {
                        emit("updateErrors", error.response.data.errors);
                    }
                })
                .finally(() => {
                    loading.value = false;
                });
        } else {
            loading.value = false;
        }
    });
};
</script>

<template>
    <div class="w-full">
        <BButton
            color="success"
            class="w-full"
            @click="showAlert"
            label="Create Role"
            type="button"
            :loading="loading"
            :disabled="loading"
        />
    </div>
</template>
