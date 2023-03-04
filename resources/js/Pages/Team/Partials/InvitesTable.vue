<script setup>
import {Link} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineProps({
    invites: {
        type: Object,
        required: true
    }
})
</script>
<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <section class="space-y-4">
            <header>
                <h2 class="text-lg font-medium text-gray-900">Invites</h2>

                <p class="mt-1 text-sm text-gray-600">
                    List of users invited to join the team
                </p>
            </header>

            <div>
                <table class="w-full">
                    <thead class="border-b">
                        <tr>
                            <th class="py-2 text-left">Address email</th>
                            <th class="py-2 text-center">Sent at</th>
                            <th class="py-2">&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="invite in invites">
                            <tr class="border-b last:border-b-0">
                                <td class="py-2 text-left">
                                    <div class="text-gray-700">{{ invite.email }}</div>
                                </td>
                                <td class="py-2 text-center">
                                    <div class="text-gray-500">
                                        {{ invite.updated_at.humanDiff }}
                                    </div>
                                </td>
                                <td class="py-2 text-right">
                                    <div class="inline-flex gap-2">
                                        <Link :href="route('teams.member.invite.resend', { invite: invite })" method="post">
                                            <SecondaryButton>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                </svg>
                                            </SecondaryButton>
                                        </Link>
                                        <Link :href="route('teams.member.invite.destroy', { invite: invite })" method="delete">
                                            <DangerButton>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </DangerButton>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>
