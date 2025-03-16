<script lang="ts" setup>
import { watch, ref } from "vue";

const props = defineProps<{
    label: string;
    name: string;
    value: string | null;
    placeholder?: string;
    error?: string;
    type?: string;
    required?: boolean;
}>();

const value = ref<string | null>(props.value);
const emit = defineEmits(["update:value"]);
watch(value, (newValue) => {
    emit("update:value", newValue);
});
</script>

<template>
    <div class="w-full">
        <label
            :hidden="!props.label"
            :for="props.name"
            class="block text-sm font-medium text-gray-700 pb-1"
            >{{ props.label }}
            {{ props.required ? "*" : "" }}
        </label>
        <a-space direction="vertical w-full">
            <a-input
                :type="props.type || 'text'"
                :class="
                    props.error
                        ? 'border border-danger-500 rounded-lg'
                        : 'rounded-lg'
                "
                :name="props.name"
                :required="props.required"
                v-model:value="value"
                v-placeholder="props.placeholder"
            />
        </a-space>
        <p class="text-red-500 text-xs italic">{{ props.error }}</p>
    </div>
</template>
