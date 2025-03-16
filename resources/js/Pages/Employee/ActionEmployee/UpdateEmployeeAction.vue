<script setup lang="ts">
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import { EmployeeData } from "@/types/employee";

const loading = ref(false); // Loading state

const toast = new Toast();

const data = defineProps<{
    form: EmployeeData;
}>();

const updateEmployee = async () => {
    return await axios.put("/employees/update/" + data.form.uuid, data.form);
};

const emit = defineEmits<{
    (event: "updateErrors", errors: Record<string, string[]>): void;
}>();

const showAlert = () => {
    Swal.fire({
        title: "Update!",
        text: "Data updated can't be reverted. Are you sure you want to update this employee?",
        icon: "warning",
        confirmButtonText: "Yes, update it!",
        showCancelButton: true,
        cancelButtonText: "No, cancel!",
    }).then((response) => {
        loading.value = true;
        emit("updateErrors", {}); // Clear errors
        if (response.isConfirmed) {
            updateEmployee()
                .then(() => {
                    toast.success("Employee updated successfully!");
                    window.location.href = route("employee.index");
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
        <!-- Close the modal -->
        <BButton
            color="success"
            class="w-full"
            @click="showAlert"
            label="Edit Employee"
            type="button"
            @modal-close="false"
            :loading="loading"
        />
    </div>
</template>
