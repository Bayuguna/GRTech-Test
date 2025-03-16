<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import BBreadcrumb from "@/Components/Atoms/BBreadcrumb.vue";
import FormEmployee from "./FormEmployee.vue";
import StoreEmployeeAction from "../ActionEmployee/StoreEmployeeAction.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import { ref } from "vue";
import { EmployeeData } from "@/types/employee";

defineProps<{}>();

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
</script>

<template>
    <div class="flex flex-col">
        <form class="space-y-4">
            <div class="flex flex-col space-y-2">
                <FormEmployee :form="form" :errors="errors" />
                <div class="flex items-center gap-2">
                    <StoreEmployeeAction
                        :form="form"
                        @updateErrors="errors = $event"
                    />
                </div>
            </div>
        </form>
    </div>
</template>
