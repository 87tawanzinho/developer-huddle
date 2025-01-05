<script setup>
import {Icon} from "@iconify/vue";

const props = defineProps({
    title: String,
    description: String,
    price: String,
    type: String,
    icon: Object,
    features: Object,
    isCurrent: Boolean,
    textSubscribe: String,
});


</script>

<template>
    <div
        class="relative bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition w-full"
    >
        <div class="p-6 text-center flex flex-col h-full justify-between p-6 text-center">
            <div>
                <div class="flex justify-center mb-4"
                     :class="`text-[${icon.color}]`"
                >
                    <Icon :icon="icon.class"
                          width="48" height="48"/>
                </div>
                <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">
                    {{ title }}
                </h2>
                <p class="text-lg text-blue-600 font-semibold mb-4">
                    R${{ price }}/mês
                </p>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-center" v-if="features.count_admins !== 0">
                        <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20"/>
                        {{ features.count_admins }}
                        {{ features.count_admins > 1 ? 'administradores' : 'administrador' }}
                    </li>
                    <li class="flex items-center" v-if="features.count_users !== 0">
                        <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20"/>
                        Até {{ features.count_users }} membros na equipe
                    </li>
                    <li class="flex items-center" v-if="features.count_projects !== 0">
                        <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20"/>
                        Crie {{ features.count_projects }} projetos simultâneos
                    </li>

                    <li class="flex items-center" v-if="type === 'free'">
                        <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20"/>
                        Participe de projetos
                    </li>
                    <li class="flex items-center" v-if="type === 'free'">
                        <Icon icon="icon-park-outline:error" class="text-red-500 mr-2" width="20" height="20"/>
                        Projetos
                    </li>
                    <!--                <li class="flex items-center">-->
                    <!--                    <Icon icon="mdi:email-outline" class="text-blue-500 mr-2" width="20" height="20"/>-->
                    <!--                    Suporte por email-->
                    <!--                </li>-->
                </ul>
            </div>

            <button v-if="!isCurrent" class="mt-6 w-full btn-primary flex items-center justify-center">
                <Icon icon="mdi:cart-outline" class="mr-2" width="20" height="20"/>
                {{textSubscribe?? 'Assinar Agora'}}
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
