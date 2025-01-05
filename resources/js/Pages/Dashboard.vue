<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {usePage} from "@inertiajs/vue3";
import {onMounted} from "vue";

const {auth} = usePage().props;

console.log(auth);

onMounted(() => {
    console.log('Profile page mounted');
});
</script>

<template>
    <AppLayout title="Perfil">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Meu Perfil
            </h2>
        </template>
    </AppLayout>
</template>
