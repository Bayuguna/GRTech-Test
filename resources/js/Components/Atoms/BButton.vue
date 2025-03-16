<script setup lang="ts">
const props = defineProps<{
    label: string;
    color?: string;
    type?: "button" | "submit" | "reset";
    loading?: boolean;
    prefixIcon?: string;
    suffixIcon?: string;
    disabled?: boolean;
}>();
</script>

<template>
    <button
        :class="'btn btn-' + props.color"
        :type="props.type ?? 'button'"
        :disabled="props.loading || props.disabled"
    >
        <div v-if="props.loading">Loading...</div>
        <div
            v-if="!props.loading"
            class="flex items-center justify-center gap-2"
        >
            <i v-if="props.prefixIcon" :class="'fa fa-' + props.prefixIcon"></i>
            <span>{{ props.label }}</span>
            <i v-if="props.suffixIcon" :class="'fa fa-' + props.suffixIcon"></i>
        </div>
    </button>
</template>
