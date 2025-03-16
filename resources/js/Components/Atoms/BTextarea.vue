<script lang="ts" setup>
import { watch, ref } from "vue";

const props = defineProps<{
    label: string;
    name: string;
    value: string;
    placeholder?: string;
    autoSize?: {
        minRows: number;
        maxRows: number;
    };
    error?: string;
}>();
const value = ref<string>(props.value);
const emit = defineEmits(["update:value"]);
watch(value, (newValue) => {
    emit("update:value", newValue);
});
</script>

<template>
    <div>
        <label
            :hidden="!props.label"
            :for="props.name"
            class="block text-sm font-medium text-gray-700 pb-1"
            >{{ props.label }}
        </label>
        <a-textarea
            v-model:value="value"
            :placeholder="props.placeholder"
            :auto-size="{
                minRows: props.autoSize?.minRows ?? 2,
                maxRows: props.autoSize?.maxRows ?? 8,
            }"
            :class="
                props.error
                    ? 'border border-danger-500 rounded-lg'
                    : 'rounded-lg'
            "
        />
        <p class="text-red-500 text-xs italic">{{ props.error }}</p>
    </div>
</template>
