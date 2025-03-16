<script lang="ts" setup>
import { ref, watch } from "vue";

const props = defineProps<{
    label: string;
    checked: boolean;
    value: String;
}>();

const checked = ref<boolean>(props.checked);
const value = ref<String>(props.value);
const emit = defineEmits(["update:value"]);

watch(checked, (newValue) => {
    if (newValue) {
        emit("update:value", "ACTIVE");
    } else {
        emit("update:value", "INACTIVE");
    }
});
</script>

<template>
    <div class="flex items-center gap-2">
        <a-switch
            v-model:checked="checked"
            v-model:value="value"
            class="active:checked:!bg-primary-500"
        />
        <span class="text-xs">{{ props.label }}</span>
    </div>
</template>
