<script setup lang="ts">
import { ref, onMounted, h, watch } from "vue";
import axios from "axios";
import { CompanyData } from "@/types/company";
import UpdateRoleAction from "../ActionRole/UpdateRoleAction.vue";
import FormRole from "./FormRole.vue";
import { RoleData } from "@/types/role";
import Access from "./Access.vue";

const props = defineProps<{
    uuid: string;
}>();
const loading = ref<boolean>(false);
const error = ref<Record<string, string[]>>({});

const form = ref<RoleData>({
    uuid: "",
    name: "",
    access_uuid: [],
});

const showRole = async () => {
    loading.value = true;
    if (!props.uuid) {
        loading.value = false;
    } else {
        const response = await axios
            .get("/settings/roles/show/" + props.uuid)
            .finally(() => {
                loading.value = false;
            });
        form.value = response.data.data;
        form.value.access_uuid = response.data.data.role_access.map(
            (access: any) => access.access_uuid
        );
    }
};

onMounted(showRole);
watch(() => props.uuid, showRole);
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
                        <FormRole :form="form" :errors="error" />
                        <Access :form="form" :errors="error" />
                    </div>
                    <div class="flex items-center gap-2">
                        <UpdateRoleAction
                            :form="form"
                            @updateErrors="error = $event"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
