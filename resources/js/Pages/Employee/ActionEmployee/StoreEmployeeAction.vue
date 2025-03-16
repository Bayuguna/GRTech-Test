<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { EmployeeData } from "@/types/employee";

const toast = new Toast();
const loading = ref(false); // Loading state

const data = defineProps<{
    form: EmployeeData;
}>();

const updateEmployee = async () => {
    return await axios.post("/employees/store", data.form);
};

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const showAlert = () => {
    Swal.fire({
        title: "Create!",
        text: "Are you sure you want to create this employee?",
        icon: "question",
        confirmButtonText: "Yes, create it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {});
        if (response.isConfirmed) {
            updateEmployee()
                .then(() => {
                    toast.success("Employee created successfully!");
                    window.location.href = route("employee.index");
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
            label="Create Employee"
            type="button"
            :loading="loading"
        />
    </div>
</template>
