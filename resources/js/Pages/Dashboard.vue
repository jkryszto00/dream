<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="space-y-4">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Tasks in progress</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Latest tasks that are in progress
                            </p>
                        </header>

                        <div class="w-full inline-flex gap-4">
                            <div class="flex-1 p-4 border rounded">
                                1st task
                            </div>
                            <div class="flex-1 p-4 border rounded">
                                2nd task
                            </div>
                            <div class="flex-1 p-4 border rounded">
                                3th task
                            </div>
                            <div class="flex-1 p-4 border rounded">
                                4th task
                            </div>
                        </div>
                    </section>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
