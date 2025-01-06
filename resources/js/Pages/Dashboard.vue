<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Icon } from "@iconify/vue";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

const { auth } = usePage().props;

console.log(auth);

onMounted(() => {
    console.log("Profile page mounted");
});
</script>

<template>
    <AppLayout title="Perfil">
        <template #header>
           <div class="">
             <div class="flex justify-between items-center pb-4 border-b-2 rounded-lg mt-16">
                <div
                    class=" flex items-center gap-8    w-full"
                >
                    <img
                        :src="$page.props.auth.user.profile_photo_url"
                        class="h-32 w-32 rounded-full"
                        alt=""
                    />
                    {{ $page.props.auth.user.subscription }}
                    <ElText style="font-size: 32px">{{
                        $page.props.auth.user.name
                    }}</ElText>
                </div>

                <Icon icon="mdi:settings" class="text-4xl text-gray-600 mt-4 transition-all hover:opacity-60 cursor-pointer" />
            </div>

            <div class="mt-24 flex flex-col items-center justify-center">
                <h2>Plano Atual</h2>
                <div class="border rounded-2xl h-64 w-64 mt-4 text-center ">
                    <span class="mt-2">{{ $page.props.auth.user.subscription.plan.name }}</span>
                </div>
            </div>
           </div>
        </template>
    </AppLayout>
</template>
