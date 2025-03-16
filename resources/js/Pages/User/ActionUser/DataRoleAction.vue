<script setup lang="ts">
import BSelect from "@/Components/Atoms/BSelect.vue";
import axios from "axios";
import { onMounted, ref } from "vue";

defineProps<{
    form: {
        company_uuid: string;
    };
    errors?: string;
}>();

const loading = ref(false);
const companies = ref<
    {
        label: string;
        value: string;
    }[]
>([]); // Data storage

const fetchCompany = async () => {
    loading.value = true;
    try {
        const response = await axios.get("/companies/select");

        console.log(response.data);
        companies.value = response.data;
    } catch (error) {
        console.error("Error fetching employees:", error);
    } finally {
        loading.value = false;
    }
};

// Call function when component loads
onMounted(fetchCompany);
</script>

<template>
    <div class="w-full" v-if="!loading">
        <BSelect
            label="Company"
            name="company"
            v-model:value="form.company_uuid"
            :placeholder="'Select Company'"
            :required="true"
            :options="
                companies.map((company) => ({
                    label: company.label,
                    value: company.value,
                }))
            "
            :error="errors"
        />
    </div>
</template>
