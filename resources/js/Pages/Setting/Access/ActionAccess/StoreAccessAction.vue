<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { AccessData } from "@/types/access";

const toast = new Toast();
const loading = ref(false); // Loading state

const data = defineProps<{
    form: AccessData;
}>();

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const updateAccess = async () => {
    return await axios.post("/settings/accesses/store", data.form);
};

const showAlert = () => {
    Swal.fire({
        title: "Create!",
        text: "Are you sure you want to save this data?",
        icon: "question",
        confirmButtonText: "Yes, create it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            updateAccess()
                .then(() => {
                    toast.success("Access created successfully!");
                    window.location.href = route("setting.access.index");
                })
                .catch((error) => {
                    toast.errors(error.message);
                    emit("updateErrors", error.response?.data?.errors);
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
            label="Create Access"
            type="button"
            :loading="loading"
            :disabled="loading"
        />
    </div>
</template>
