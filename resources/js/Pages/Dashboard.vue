<script setup lang="ts">
import BBreadcrumb from "@/Components/Atoms/BBreadcrumb.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import VuePdfEmbed from "vue-pdf-embed";

defineProps<{
    userAuth: {
        name: string;
    };
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <BBreadcrumb
                :routes="[
                    { title: 'Home', href: '/' },
                    { title: 'Dashboard', href: route('dashboard') },
                ]"
            />
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <VuePdfEmbed :source="'/document/test-1.pdf'" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
