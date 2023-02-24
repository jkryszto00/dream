<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MembersTable from "@/Pages/Team/Partials/MembersTable.vue";
import InvitesTable from "@/Pages/Team/Partials/InvitesTable.vue";

defineProps({
    members: {
        type: Object,
        required: true
    },
    invites: {
        type: Object,
        required: true
    }
})
</script>
<template>
    <Head title="Team" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Team</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <MembersTable :members="members" />

                <InvitesTable :invites="invites" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
