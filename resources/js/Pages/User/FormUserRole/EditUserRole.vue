<script setup lang="ts">
import BTextfiled from "@/Components/Atoms/BTextfield.vue";
import BSwitch from "@/Components/Atoms/BSwitch.vue";
import { UserData } from "@/types/user";
import BSelect from "@/Components/Atoms/BSelect.vue";
import axios from "axios";
import { h, onMounted, ref } from "vue";
import { Toast } from "@/Components/Atoms/BToast.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import TableUserRole from "./TableUserRole.vue";
import Swal from "sweetalert2";

const props = defineProps<{
    uuid: string;
}>();

const loading = ref(false);
const toast = new Toast();
const selectRole = ref<string>("");
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

const storeUserRole = async () => {
    const url = route("user_role.store", {
        role_uuid: selectRole.value,
        user_uuid: props.uuid,
    });
    return await axios
        .post(url)
        .then(() => {
            toast.success("User created successfully!");
            window.location.href = route("user.index");
        })
        .catch((error) => {
            toast.errors(error.response.data.message);
        })
        .finally(() => {
            loading.value = false;
        });
};

onMounted(fetchRole);
</script>

<template>
    <div class="pb-4">
        <div class="flex flex-col space-y-2">
            <div>
                <div v-if="roles.length > 0" class="pt-2">
                    <form class="space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="w-full">
                                <BSelect
                                    label="Company"
                                    name="company"
                                    v-model:value="selectRole"
                                    :placeholder="'Select Company'"
                                    :required="true"
                                    :options="
                                        roles.map((role) => ({
                                            label: role.label,
                                            value: role.value,
                                        }))
                                    "
                                />
                            </div>
                            <div class="pt-2">
                                <BButton
                                    color="success"
                                    class="w-full"
                                    @click="storeUserRole"
                                    label="Add"
                                    type="button"
                                    :loading="loading"
                                />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <TableUserRole :uuid="uuid" />
        </div>
    </div>
</template>
