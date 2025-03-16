<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { CompanyData } from "@/types/company";

const loading = ref(false); // Loading state

const toast = new Toast();

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const data = defineProps<{
    form: CompanyData;
}>();

const updateCompany = async () => {
    const formData = new FormData();
    formData.append("name", data.form.name);
    formData.append("email", data.form.email);
    formData.append("logo", data.form.logo as File);
    formData.append("website", data.form.website);
    formData.append("status", data.form.status);
    formData.append("address", data.form.address);
    formData.append("phone", data.form.phone);

    return await axios.post("/companies/update/" + data.form.uuid, formData, {
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    });
};

const showAlert = () => {
    Swal.fire({
        title: "Update!",
        text: "Data updated can't be reverted. Are you sure you want to update this company?",
        icon: "warning",
        confirmButtonText: "Yes, update it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            updateCompany()
                .then(() => {
                    toast.success("Company updated successfully!");
                    window.location.href = route("company.index");
                })
                .catch((error) => {
                    toast.errors("Error updating employee!");
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
            label="Edit Company"
            type="button"
            :loading="loading"
        />
    </div>
</template>
