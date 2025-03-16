<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { AccessData } from "@/types/access";

const loading = ref(false); // Loading state

const toast = new Toast();

const data = defineProps<{
    form: AccessData;
}>();

const updateAccess = async () => {
    return await axios.put(
        "/settings/accesses/update/" + data.form.uuid,
        data.form
    );
};

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const showAlert = () => {
    Swal.fire({
        title: "Update!",
        text: "Data updated can't be reverted. Are you sure you want to update this access?",
        icon: "warning",
        confirmButtonText: "Yes, update it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            updateAccess()
                .then(() => {
                    toast.success("Access updated successfully!");
                    window.location.href = route("setting.access.index");
                })
                .catch((error) => {
                    toast.errors("Error updating Access!");
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
            label="Edit Access"
            type="button"
            :loading="loading"
            :disabled="loading"
        />
    </div>
</template>
