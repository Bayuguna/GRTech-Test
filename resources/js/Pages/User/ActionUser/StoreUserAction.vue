<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { UserData } from "@/types/user";

const toast = new Toast();
const loading = ref(false); // Loading state

const data = defineProps<{
    form: UserData;
}>();

const updateUser = async () => {
    const url = route("user.store");
    return await axios.post(url, data.form);
};

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const showAlert = () => {
    Swal.fire({
        title: "Create!",
        text: "Are you sure you want to create this user?",
        icon: "question",
        confirmButtonText: "Yes, create it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            updateUser()
                .then(() => {
                    toast.success("User created successfully!");
                    window.location.href = route("user.index");
                })
                .catch((error) => {
                    console.log("error", error);
                    toast.errors(error.response.data.message);
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
            label="Create User"
            type="button"
            :loading="loading"
        />
    </div>
</template>
