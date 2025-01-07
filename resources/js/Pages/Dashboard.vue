<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Icon } from "@iconify/vue";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import PlanCard from "@/Components/PlanCard.vue";
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
                <div
                    class="flex justify-between items-center pb-4 border-b-2 rounded-lg mt-16"
                >
                    <div class="flex items-center gap-8">
                        <img
                            :src="$page.props.auth.user.profile_photo_url"
                            class="h-32 w-32 rounded-full"
                            alt=""
                        />

                        <ElText style="font-size: 32px">{{
                            $page.props.auth.user.name
                        }}</ElText>
                    </div>

                    <Icon
                        icon="mdi:settings"
                        class="text-4xl text-gray-600 mt-4 transition-all hover:opacity-60 cursor-pointer"
                    />
                </div>

                <div class="mt-24 flex flex-col items-center justify-center">
                    <h2 class="mb-6 text-2xl">Meu Plano Atual</h2>
                    <PlanCard
                        :title="$page.props.auth.user.subscription.plan.name"
                        :description="
                            $page.props.auth.user.subscription.plan.description
                        "
                        :price="$page.props.auth.user.subscription.plan.price"
                        :type="$page.props.auth.user.subscription.plan.type"
                        :icon="$page.props.auth.user.subscription.plan.icon"
                        :features="{
                            count_users:
                                $page.props.auth.user.subscription.plan
                                    .count_project,
                            count__projects:
                                $page.props.auth.user.subscription.plan
                                    .count_users_project,
                            count_admins:
                                $page.props.auth.user.subscription.plan
                                    .count_admin_project,
                        }"
                        :isCurrent="true"
                        textSubscribe="Mudar de Plano"
                        :changeStyle="true"
                    />
                </div>
            </div>
        </template>
    </AppLayout>
</template>
