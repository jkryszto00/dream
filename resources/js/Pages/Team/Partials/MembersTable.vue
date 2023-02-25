<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, Link } from "@inertiajs/vue3";


defineProps({
    members: {
        type: Object,
        required: true
    }
})

const emailInput = ref(null);

const form = useForm({
    email: ''
})

const showModal = ref(false)
const showInviteMember = () => {
    showModal.value = true
}

const inviteMember = () => {
    form.post(route('teams.member.invite'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => emailInput.value.focus(),
        onFinish: () => form.reset()
    })
}

const closeModal = () => {
    showModal.value = false

    form.clearErrors()
    form.reset()
}
</script>
<template>
    <Modal :show="showModal" max-width="md" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Invite new team member to the team
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please
                enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="mt-6">
                <form>
                    <TextInput
                        id="email"
                        ref="emailInput"
                        type="email"
                        v-model="form.email"
                        class="block w-full"
                        placeholder="member@example.com"
                        @keyup.enter="inviteMember"
                    />

                    <InputError :message="form.errors.email" />
                </form>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="inviteMember"
                >
                    Invite member
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <section class="space-y-4">
            <header class="w-full inline-flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Members</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        List of team members
                    </p>
                </div>

                <PrimaryButton @click="showInviteMember">
                    Add member
                </PrimaryButton>
            </header>

            <div>
                <table class="w-full">
                    <thead class="border-b">
                        <tr>
                            <th class="py-2 text-left">Name</th>
                            <th class="py-2 text-center">Role</th>
                            <th class="py-2">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="member in members" :key="member.id">
                            <tr class="border-b last:border-b-0">
                                <td class="py-2 text-left">
                                    <span class="block font-medium text-gray-700">{{ member.name }}</span>
                                    <span class="block text-sm text-gray-500">{{ member.email }}</span>
                                </td>
                                <td class="py-2 text-center">
                                    <span class="px-2 py-0.5 rounded bg-indigo-100 text-indigo-500">
                                        Owner
                                    </span>
                                </td>
                                <td class="py-2 text-right">
                                    <SecondaryButton>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </SecondaryButton>
                                    <Link :href="route('teams.members.detach', { user: member.id })" method="post">
                                        <DangerButton
                                            class="ml-3"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </DangerButton>
                                    </Link>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>
