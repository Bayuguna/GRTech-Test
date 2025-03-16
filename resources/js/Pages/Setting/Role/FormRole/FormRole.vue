<script setup lang="ts">
import BTextfiled from "@/Components/Atoms/BTextfield.vue";
import { RoleData } from "@/types/role";

defineProps<{
    form: RoleData;
    errors?: Record<string, string[]>;
}>();
</script>

<template>
    <div class="pb-4">
        <div class="flex flex-col space-y-2">
            <BTextfiled
                label="Name"
                name="name"
                v-model:value="form.name"
                :error="errors?.name && errors?.name[0]"
            />
        </div>
    </div>
</template>
