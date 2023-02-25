<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    token: {
        type: String,
        required: true
    }
})

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('teams.member.invite.continue', { token: props.token }), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Join to the team" />

    <GuestLayout>
        <div class="space-y-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Join to dsgnly team</h2>
            <div class="mb-4 text-sm text-gray-600 ">
                To join the team and collaborate. Enter the email address you wish to use.
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="flex justify-end mt-4">
                    <PrimaryButton class="w-full inline-flex justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Continue with email
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
