<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import BBreadcrumb from "@/Components/Atoms/BBreadcrumb.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import FormCompany from "./FormCompany.vue";
import StoreCompanyAction from "../ActionCompany/StoreCompanyAction.vue";
import { ref } from "vue";
import { CompanyData } from "@/types/company";

defineProps<{}>();

const form = ref<CompanyData>({
    uuid: "",
    name: "",
    email: "",
    website: "",
    logo: null,
    address: "",
    phone: "",
    status: "ACTIVE",
});

const errors = ref<Record<string, string[]>>({});
</script>

<template>
    <div class="flex flex-col">
        <form class="space-y-4" :enctype="'multipart/form-data'">
            <div class="flex flex-col space-y-2">
                <FormCompany :form="form" :errors="errors" />
                <div class="flex items-center gap-2">
                    <StoreCompanyAction
                        :form="form"
                        @updateErrors="errors = $event"
                    />
                </div>
            </div>
        </form>
    </div>
</template>
