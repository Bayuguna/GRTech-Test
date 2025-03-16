<script setup lang="ts">
import BTextfiled from "@/Components/Atoms/BTextfield.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import BSwitch from "@/Components/Atoms/BSwitch.vue";
import BSelect from "@/Components/Atoms/BSelect.vue";
import DataCompanyAction from "../ActionEmployee/DataCompanyAction.vue";
import { EmployeeData } from "@/types/employee";

defineProps<{
    form: EmployeeData;
    errors?: Record<string, string[]>;
}>();
</script>

<template>
    <div class="pb-4">
        <div>
            <div class="flex justify-end">
                <div class="flex gap-2 items-center">
                    <BSwitch
                        :label="form.status"
                        name="status"
                        :checked="form.status === 'ACTIVE'"
                        v-model:value="form.status"
                    />
                </div>
            </div>
        </div>
        <div class="flex flex-col space-y-2">
            <!-- <BTextfiled
                label="First Name"
                name="first_name"
                type="file"
                v-model:value="form.first_name"
            /> -->
            <BTextfiled
                label="First Name"
                name="first_name"
                :required="true"
                v-model:value="form.first_name"
                :error="errors?.first_name && errors?.first_name[0]"
            />
            <BTextfiled
                label="Last Name"
                name="last_name"
                :required="true"
                v-model:value="form.last_name"
                :error="errors?.last_name && errors?.last_name[0]"
            />
            <BTextfiled
                label="Email"
                name="email"
                :required="true"
                v-model:value="form.email"
                :error="errors?.email && errors?.email[0]"
            />
            <BTextfiled
                label="Phone"
                name="phone"
                :required="true"
                v-model:value="form.phone"
                :error="errors?.phone && errors?.phone[0]"
            />
            <DataCompanyAction
                :form="form"
                :error="errors?.company_uuid && errors?.company_uuid[0]"
            />
        </div>
    </div>
</template>
