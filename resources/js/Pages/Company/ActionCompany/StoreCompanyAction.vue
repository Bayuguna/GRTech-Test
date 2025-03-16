<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { CompanyData } from "@/types/company";

const toast = new Toast();
const loading = ref(false); // Loading state

const data = defineProps<{
    form: CompanyData;
}>();

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const storeCompany = async () => {
    const formData = new FormData();
    formData.append("name", data.form.name);
    formData.append("email", data.form.email);
    formData.append("logo", data.form.logo as File);
    formData.append("website", data.form.website);
    formData.append("status", data.form.status);
    formData.append("address", data.form.address);
    formData.append("phone", data.form.phone);

    return await axios.post("/companies/store", formData, {
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    });
};

const showAlert = () => {
    Swal.fire({
        title: "Create!",
        text: "Are you sure you want to create this company?",
        icon: "question",
        confirmButtonText: "Yes, create it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            storeCompany()
                .then(() => {
                    toast.success("Company created successfully!");
                    window.location.href = route("company.index");
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
            label="Create Company"
            type="button"
            :loading="loading"
        />
    </div>
</template>
