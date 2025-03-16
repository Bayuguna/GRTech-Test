<script setup lang="ts">
const props = defineProps<{
    routes?: { title: string; href: string }[];
}>();
</script>

<template>
    <a-breadcrumb>
        <a-breadcrumb-item
            v-for="breadcrumb in props.routes"
            :key="breadcrumb.title"
        >
            <a :href="breadcrumb.href">
                {{ breadcrumb.title }}
            </a>
        </a-breadcrumb-item>
    </a-breadcrumb>
</template>
