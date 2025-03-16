<script lang="ts" setup>
import { ref, watch } from "vue";
import { UploadOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";
import type { UploadProps } from "ant-design-vue";

const props = defineProps<{
    value: File | null; // Expect a File object
    label?: string;
    name: string;
    error?: string;
    required?: boolean;
    accept?: string;
}>();

const emit = defineEmits<{
    (event: "update:value", file: File | null): void;
}>();

const fileList = ref<UploadProps["fileList"]>([]);

watch(
    () => props.value,
    (newValue) => {
        if (newValue) {
            fileList.value = [{ name: newValue.name } as any];
        } else {
            fileList.value = [];
        }
    },
    { immediate: true }
);

const handleRemove: UploadProps["onRemove"] = () => {
    fileList.value = [];
    emit("update:value", null);
};

const beforeUpload: UploadProps["beforeUpload"] = (file) => {
    const isImage = file.type.startsWith("image/");
    if (!isImage) {
        message.error("You can only upload image files!");
        return false;
    }

    emit("update:value", file);

    fileList.value = [{ name: file.name } as any];

    return false;
};
</script>

<template>
    <div class="clearfix">
        <a-upload
            :file-list="fileList"
            :before-upload="beforeUpload"
            @remove="handleRemove"
            :max-count="1"
            list-type="picture"
            :accept="props.accept"
        >
            <a-button v-if="fileList && fileList.length === 0">
                <upload-outlined></upload-outlined>
                Select Image
            </a-button>
        </a-upload>
        <p class="text-red-500 text-xs italic pt-1">{{ props.error }}</p>
    </div>
</template>
