<script setup lang="ts">
import BTextfiled from "@/Components/Atoms/BTextfield.vue";
import BSwitch from "@/Components/Atoms/BSwitch.vue";
import { UserData } from "@/types/user";
import BSelect from "@/Components/Atoms/BSelect.vue";
import axios from "axios";
import { onMounted, ref } from "vue";

defineProps<{
    form: UserData;
    errors?: Record<string, string[]>;
    form_type: "create" | "edit";
}>();

const roles = ref<
    {
        label: string;
        value: string;
    }[]
>([]);

const fetchRole = async () => {
    const url = route("setting.role.select");
    const response = await axios.get(url);
    roles.value = response.data;
};

onMounted(fetchRole);
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
            <div :hidden="form_type === 'edit'">
                <div>
                    <BTextfiled
                        label="Password"
                        name="password"
                        v-model:value="form.password"
                        :error="errors?.password && errors?.password[0]"
                    />
                    <span class="text-xs"
                        >Password default:
                        <span class="font-semibold italic">password</span></span
                    >
                </div>
                <div v-if="roles.length > 0" class="pt-2">
                    <BSelect
                        label="Role"
                        name="role_uuid"
                        mode="multiple"
                        :options="roles"
                        v-model:value="form.role_uuid"
                        :error="errors?.role && errors?.role[0]"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
