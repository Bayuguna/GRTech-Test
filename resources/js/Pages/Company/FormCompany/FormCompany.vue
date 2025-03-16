<script setup lang="ts">
import BTextfiled from "@/Components/Atoms/BTextfield.vue";
import BSwitch from "@/Components/Atoms/BSwitch.vue";
import { CompanyData } from "@/types/company";
import BFileUpload from "@/Components/Atoms/BFileUpload.vue";
import BTextarea from "@/Components/Atoms/BTextarea.vue";

defineProps<{
    form: CompanyData;
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
            <BFileUpload
                v-model:value="form.logo"
                name="logo"
                :error="errors?.logo && errors?.logo[0]"
                :accept="'image/*'"
            />
            <BTextfiled
                label="Name"
                name="name"
                :required="true"
                v-model:value="form.name"
                :error="errors?.name && errors?.name[0]"
            />
            <BTextfiled
                label="Email"
                name="email"
                :required="true"
                v-model:value="form.email"
                :error="errors?.email && errors?.email[0]"
            />
            <BTextfiled
                label="Website"
                name="website"
                type="url"
                v-model:value="form.website"
                :error="errors?.website && errors?.website[0]"
            />
            <BTextfiled
                label="Phone"
                name="phone"
                v-model:value="form.phone"
                :error="errors?.phone && errors?.phone[0]"
            />
            <BTextarea
                label="Address"
                name="address"
                v-model:value="form.address"
                :auto-size="{ minRows: 4, maxRows: 6 }"
                :error="errors?.address && errors?.address[0]"
            />
        </div>
    </div>
</template>
