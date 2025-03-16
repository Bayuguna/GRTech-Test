<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { RoleData } from "@/types/role";

const loading = ref(false); // Loading state

const toast = new Toast();

const data = defineProps<{
    form: RoleData;
}>();

const updateRole = async () => {
    return await axios.put(
        "/settings/roles/update/" + data.form.uuid,
        data.form
    );
};

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const showAlert = () => {
    Swal.fire({
        title: "Update!",
        text: "Are you sure you want to update this data?",
        icon: "warning",
        confirmButtonText: "Yes, update it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            updateRole()
                .then(() => {
                    toast.success("Role updated successfully!");
                    window.location.href = route("setting.role.index");
                })
                .catch((error) => {
                    toast.errors("Error updating Role!");
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
            label="Edit Role"
            type="button"
            :loading="loading"
        />
    </div>
</template>
