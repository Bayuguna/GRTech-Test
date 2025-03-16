<script setup lang="ts">
import { ref, onMounted, h, watch } from "vue";
import axios from "axios";
import FormCompany from "./FormAccess.vue";
import { CompanyData } from "@/types/company";
import UpdateAccessAction from "../ActionAccess/UpdateAccessAction.vue";
import { AccessData } from "@/types/access";

const props = defineProps<{
    uuid: string;
}>();
const loading = ref<boolean>(false);

const form = ref<AccessData>({
    uuid: "",
    name: "",
});

const showAccess = async () => {
    loading.value = true;
    if (!props.uuid) {
        loading.value = false;
    } else {
        const response = await axios
            .get("/settings/accesses/show/" + props.uuid)
            .finally(() => {
                loading.value = false;
            });
        form.value = response.data.data;
    }
};

onMounted(showAccess);
watch(() => props.uuid, showAccess);
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
                    <div v-if="!loading && !form.uuid">
                        <div class="flex justify-center">
                            <div class="loader">Data not found</div>
                        </div>
                    </div>
                    <div v-if="!loading && form.uuid">
                        <FormCompany :form="form" />
                    </div>
                    <div class="flex items-center gap-2">
                        <UpdateAccessAction :form="form" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
