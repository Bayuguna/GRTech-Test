<script setup lang="ts">
import { ref } from "vue";
import { AccessData } from "@/types/access";
import FormAccess from "./FormAccess.vue";
import StoreAccessAction from "../ActionAccess/StoreAccessAction.vue";

defineProps<{}>();

const form = ref<AccessData>({
    uuid: "",
    name: "",
});

const errors = ref<Record<string, string[]>>({});
</script>

<template>
    <div class="flex flex-col">
        <form class="space-y-4">
            <div class="flex flex-col space-y-2">
                <FormAccess :form="form" :errors="errors" />
                <div class="flex items-center gap-2">
                    <StoreAccessAction
                        :form="form"
                        @updateErrors="errors = $event"
                    />
                </div>
            </div>
        </form>
    </div>
</template>
