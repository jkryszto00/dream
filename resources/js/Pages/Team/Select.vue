<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    teams: {
        type: Object,
        required: true
    }
})
</script>
<template>
    <Head title="Select team" />

    <GuestLayout>
        <div class="space-y-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Select team</h2>

            <div class="mb-4 text-sm text-gray-600 ">
                To continue you must select an active team
            </div>

            <div class="space-y-4">
                <template v-for="team in teams" :key="team.id">
                    <div class="w-full inline-flex p-4 items-center justify-between border rounded-md">
                        <div class="font-medium">
                            {{ team.name }}
                            <span
                                v-if="team.user_id === $page.props.auth.user.id"
                                class="ml-2 bg-indigo-100 px-2 py-0.5 text-sm rounded-md text-indigo-700"
                            >
                                Owner
                            </span>
                        </div>
                        <Link :href="route('teams.selected', { team: team })" method="post">
                            <SecondaryButton>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                </svg>
                            </SecondaryButton>
                        </Link>
                    </div>
                </template>
            </div>
        </div>
    </GuestLayout>
</template>
