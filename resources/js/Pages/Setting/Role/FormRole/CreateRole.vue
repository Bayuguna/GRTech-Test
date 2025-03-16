<script setup lang="ts">
import { ref } from "vue";
import { AccessData } from "@/types/access";
import { RoleData } from "@/types/role";
import StoreRoleAction from "../ActionRole/StoreRoleAction.vue";
import FormRole from "./FormRole.vue";
import Access from "./Access.vue";

defineProps<{}>();

const form = ref<RoleData>({
    uuid: "",
    name: "",
    access_uuid: [],
});
const error = ref<Record<string, string[]>>({});
</script>

<template>
    <div class="flex flex-col">
        <form class="space-y-4">
            <div class="flex flex-col space-y-2">
                <FormRole :form="form" :errors="error" />
                <Access :form="form" :errors="error" />
                <div class="flex items-center gap-2">
                    <StoreRoleAction
                        :form="form"
                        @updateErrors="error = $event"
                    />
                </div>
            </div>
        </form>
    </div>
</template>
