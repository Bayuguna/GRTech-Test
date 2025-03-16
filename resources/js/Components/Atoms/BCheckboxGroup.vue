<script lang="ts" setup>
import { ref, watch } from "vue";

const props = defineProps<{
    label: string;
    value?: string[];
    name: string;
    options: { label: string; value: string }[];
    error?: string;
    required?: boolean;
}>();

const emit = defineEmits(["update:value"]);

const value = ref(props.value || []);

// Watch for changes and emit updates
watch(value, (newValue) => {
    console.log("value", newValue);
    emit("update:value", newValue);
});
</script>

<template>
    <div>
        <div class="flex justify-between pb-1">
            <label
                :hidden="!props.label"
                :for="props.name"
                class="block text-sm font-medium text-gray-700 pb-1"
                >{{ props.label }}
                {{ props.required ? "*" : "" }}
            </label>
            <span class="text-red-500 text-xs italic">{{ props.error }}</span>
        </div>
        <a-checkbox-group
            v-model:value="value"
            :name="props.name"
            :options="props.options"
            class="flex flex-col gap-2"
        />
    </div>
</template>
