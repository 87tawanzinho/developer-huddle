<template>
    <Head title="Planos" />
    <div class="flex flex-col lg:flex-row">
        <SidebarLayout/>
        <div class="flex justify-center w-full mt-2 px-4">
            <div
                class="flex flex-col items-center bg-gray-50 py-4 px-4 sm:px-6 lg:px-12 rounded-lg shadow-lg w-full max-w-5xl">

                <div class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 lg:mb-3 text-center">
                    Plano Atual
                </div>
                <div class="justify-center mb-6">
                    <PlanCard :title="currentPlan.name"
                              :description="currentPlan.description"
                              :price="currentPlan.price"
                              :icon="currentPlan.icon"
                              :type="currentPlan.type"
                              :is-current="true"
                              :features="{
                            count_admins: currentPlan.count_admin_project,
                            count_users: currentPlan.count_users_project,
                            count_projects: currentPlan.count_projects
                      }"/>
                </div>

                <div class="text-xl lg:text-2xl font-bold text-gray-900 mb-4 lg:mb-6 text-center">
                    Escolha seu Plano
                </div>
                <p class="text-gray-700 text-base lg:text-lg mb-6 lg:mb-8 text-center">
                    Adapte a sua equipe com o plano ideal. Comece a criar projetos hoje mesmo!
                </p>
                <div class="grid gap-6 sm:gap-8 lg:grid-cols-3 w-full">
                    <PlanCard v-for="plan in plans"
                              :key="plan.id"
                              :title="plan.name"
                              :description="plan.description"
                              :price="plan.price"
                              :icon="plan.icon"
                              :type="plan.type"
                              :text-subscribe="textSubscribe"
                              :features="{
                            count_admins: plan.count_admin_project,
                            count_users: plan.count_users_project,
                            count_projects: plan.count_projects
                      }"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
import PlanCard from "@/Components/PlanCard.vue";
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    plans: Object,
    currentPlan: Object,
});

let textSubscribe;

if (props.currentPlan.type !== 'free') {
    textSubscribe = 'Alterar Plano';
}

</script>
<style>
.btn-primary {
    @apply bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold py-2 px-4 rounded-md transition hover:from-blue-600 hover:to-purple-600;
}
</style>
