<template>
    <Head :title="`Projeto ${id}`" />
    <div class="flex">
        <SidebarLayout/>
        <div class="p-24">
            dsfdsf
        </div>
    </div>
   
</template>

<script setup>
 import SidebarLayout from '@/Layouts/SidebarLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

defineProps([
    'id'
])
</script>