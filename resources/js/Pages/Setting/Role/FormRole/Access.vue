<script setup lang="ts">
import BCheckboxGroup from "@/Components/Atoms/BCheckboxGroup.vue";
import { AccessData } from "@/types/access";
import { RoleData } from "@/types/role";
import axios from "axios";
import { onMounted, ref } from "vue";

const props = defineProps<{
    form: RoleData;
    errors: Record<string, string[]>;
}>();

const accesses = ref<AccessData[]>([]);
const loading = ref<boolean>(true);

const fetchAccess = async () => {
    const response = await axios.get("/settings/accesses/data").finally(() => {
        loading.value = false;
    });

    console.log("access", response.data.data);
    accesses.value = response.data.data;
};

onMounted(fetchAccess);
</script>

<template>
    <div v-if="loading && !accesses.length">
        <div class="flex justify-center">
            <div class="loader">Loading...</div>
        </div>
    </div>
    <div v-if="accesses.length" class="max-h-72 overflow-y-auto">
        <BCheckboxGroup
            label="Access"
            name="access"
            v-model:value="props.form.access_uuid"
            :required="true"
            :error="props.errors.access_uuid && props.errors.access_uuid[0]"
            :options="
                accesses.map((access) => ({
                    label: access.name,
                    value: access.uuid,
                }))
            "
        />
    </div>
</template>
