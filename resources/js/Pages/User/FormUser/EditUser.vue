<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, onMounted, h, watch } from "vue";
import BBreadcrumb from "@/Components/Atoms/BBreadcrumb.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import axios from "axios";
import FormUser from "./FormUser.vue";
import UpdateUserAction from "../ActionUser/UpdateUserAction.vue";
import { UserData } from "@/types/user";

const props = defineProps<{
    uuid: string;
}>();
const loading = ref<boolean>(false);

const form = ref<UserData>({
    uuid: "",
    name: "",
    status: "ACTIVE",
    email: "",
    password: "",
    role_uuid: [],
});
const errors = ref<Record<string, string[]>>({});

const showUser = async () => {
    loading.value = true;
    if (!props.uuid) {
        loading.value = false;
    } else {
        const url = route("user.show", { uuid: props.uuid });
        const response = await axios.get(url).finally(() => {
            loading.value = false;
        });
        form.value = response.data.data;
    }
};

onMounted(showUser);
watch(() => props.uuid, showUser);
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
                    <div v-if="!loading && form.uuid">
                        <FormUser
                            :form="form"
                            :errors="errors"
                            :form_type="'edit'"
                        />
                    </div>
                    <div class="flex items-center gap-2">
                        <UpdateUserAction
                            :form="form"
                            @updateErrors="errors = $event"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
