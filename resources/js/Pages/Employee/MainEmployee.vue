<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BBreadcrumb from "@/Components/Atoms/BBreadcrumb.vue";
import BButton from "@/Components/Atoms/BButton.vue";
import TableEmployee from "./TableEmployee.vue";
</script>

<template>
    <Head title="Employee" />

    <AuthenticatedLayout>
        <template #header>
            <BBreadcrumb
                :routes="[
                    { title: 'Home', href: '/' },
                    { title: 'Employee', href: '/employee' },
                ]"
            />
        </template>
        <div>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <TableEmployee />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
