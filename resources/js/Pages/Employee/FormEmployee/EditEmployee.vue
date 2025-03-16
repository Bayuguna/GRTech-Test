<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, onMounted, h, watch } from "vue";
import BBreadcrumb from "@/Components/Atoms/BBreadcrumb.vue";
import UpdateEmployeeAction from "../ActionEmployee/UpdateEmployeeAction.vue";
import FormEmployee from "./FormEmployee.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import { EmployeeData } from "@/types/employee";
import axios from "axios";

const props = defineProps<{
    uuid: string;
}>();
const loading = ref<boolean>(false);

const form = ref<EmployeeData>({
    uuid: "",
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    status: "ACTIVE",
    company_uuid: "",
});
const errors = ref<Record<string, string[]>>({});

const showEmployee = async () => {
    loading.value = true;
    if (!props.uuid) {
        loading.value = false;
    } else {
        const response = await axios
            .get("/employees/show/" + props.uuid)
            .finally(() => {
                loading.value = false;
            });
        form.value = response.data.data;
    }
};

onMounted(showEmployee);
watch(() => props.uuid, showEmployee);
</script>

<template>
    <div>
        <div class="flex flex-col">
            <form class="space-y-4">
                <div class="flex flex-col space-y-2">
                    <div v-if="loading">
                        <div class="flex justify-center">
                            <div class="loader">Loading...</div>
                        </div>
                    </div>
                    <div v-if="!loading && form.uuid">
                        <FormEmployee :form="form" :errors="errors" />
                    </div>
                    <div class="flex items-center gap-2">
                        <UpdateEmployeeAction
                            :form="form"
                            @updateErrors="errors = $event"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
