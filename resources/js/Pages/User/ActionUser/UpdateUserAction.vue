<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { UserData } from "@/types/user";

const loading = ref(false); // Loading state

const toast = new Toast();

const data = defineProps<{
    form: UserData;
}>();

const updateUser = async () => {
    return await axios.put("/users/update/" + data.form.uuid, data.form);
};

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const showAlert = () => {
    Swal.fire({
        title: "Update!",
        text: "Data updated can't be reverted. Are you sure you want to update this user?",
        icon: "warning",
        confirmButtonText: "Yes, update it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {}); // Clear errors
        if (response.isConfirmed) {
            updateUser()
                .then(() => {
                    toast.success("User updated successfully!");
                    window.location.href = route("user.index");
                })
                .catch((error) => {
                    toast.errors("Error updating user!");
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
        <!-- Close the modal -->
        <BButton
            color="success"
            class="w-full"
            @click="showAlert"
            label="Edit User"
            type="button"
            @modal-close="true"
            :loading="loading"
        />
    </div>
</template>
