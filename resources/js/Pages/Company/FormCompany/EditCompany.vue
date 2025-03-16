<script setup lang="ts">
import { ref, onMounted, h, watch } from "vue";
import axios from "axios";
import FormCompany from "./FormCompany.vue";
import UpdateCompanyAction from "../ActionCompany/UpdateCompanyAction.vue";
import { CompanyData } from "@/types/company";

const props = defineProps<{
    uuid: string;
}>();
const loading = ref<boolean>(false);

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

const showEmployee = async () => {
    loading.value = true;
    if (!props.uuid) {
        loading.value = false;
    } else {
        const response = await axios
            .get("/companies/show/" + props.uuid)
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
            <form class="space-y-4" :enctype="'multipart/form-data'">
                <div class="flex flex-col space-y-2">
                    <div v-if="loading">
                        <div class="flex justify-center">
                            <div class="loader">Loading...</div>
                        </div>
                    </div>
                    <div v-if="!loading && !form.uuid">
                        <div class="flex justify-center">
                            <div class="loader">Data not found</div>
                        </div>
                    </div>
                    <div v-if="!loading && form.uuid">
                        <FormCompany :form="form" :errors="errors" />
                    </div>
                    <div class="flex items-center gap-2">
                        <UpdateCompanyAction
                            :form="form"
                            @updateErrors="errors = $event"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
