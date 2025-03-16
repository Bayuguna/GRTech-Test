<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import BBreadcrumb from "@/Components/Atoms/BBreadcrumb.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import { ref } from "vue";
import FormUser from "./FormUser.vue";
import StoreUserAction from "../ActionUser/StoreUserAction.vue";
import { UserData } from "@/types/user";

defineProps<{}>();

const form = ref<UserData>({
    uuid: "",
    name: "",
    status: "ACTIVE",
    email: "",
    password: null,
    role_uuid: [],
});

const errors = ref<Record<string, string[]>>({});
</script>

<template>
    <div class="flex flex-col">
        <form class="space-y-4">
            <div class="flex flex-col space-y-2">
                <FormUser :form="form" :errors="errors" :form_type="'create'" />
                <div class="flex items-center gap-2">
                    <StoreUserAction
                        :form="form"
                        @updateErrors="errors = $event"
                    />
                </div>
            </div>
        </form>
    </div>
</template>
