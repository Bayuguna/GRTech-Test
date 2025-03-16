<script lang="ts" setup>
import { ref } from "vue";
import type { SelectProps } from "ant-design-vue";

const props = defineProps<{
    label: string;
    options: SelectProps["options"];
    value: string | string[] | null;
    placeholder?: string;
    name?: string;
    error?: string;
    required?: boolean;
    mode?: "multiple" | "tags" | "default";
}>();

const value = ref(props.value);
const options = ref<SelectProps["options"]>(props.options);

const focus = () => {
    console.log("focus");
};

const emit = defineEmits(["update:value"]);
const handleChange = (newValue: string) => {
    emit("update:value", newValue);
};
</script>

<template>
    <div>
        <label
            :hidden="!props.label"
            :for="props.label"
            class="block text-sm font-medium text-gray-700 pb-1"
            >{{ props.label }}
            {{ props.required ? "*" : "" }}
        </label>
        <a-space class="w-full flex flex-col">
            <a-select
                ref="select"
                :mode="props.mode"
                :placeholder="props.placeholder"
                :name="props.name"
                v-model:value="value"
                :options="options"
                @focus="focus"
                @change="handleChange"
                :class="
                    props.error
                        ? 'w-full border border-danger-500 rounded-lg'
                        : 'w-full rounded-lg'
                "
            ></a-select>
            <p class="text-red-500 text-xs italic">{{ props.error }}</p>
        </a-space>
    </div>
</template>
