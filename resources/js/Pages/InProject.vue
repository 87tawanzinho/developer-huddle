<template>
    <Head :title="`Projeto ${id}`" />
    <div class="border border-gray-200 rounded-lg p-4 flex ">
        <h1 class="text-2xl font-bold">Projeto {id}</h1>
        <p class="text-gray-500">Aqui você pode gerenciar o projeto.</p>
        <div class="mt-4">
            <Link class="bg-blue-500 text-white px-4 py-2 rounded-lg">Voltar</Link>
        </div>

    </div>
</template>

<script setup>
 import { Head, Link, usePage } from '@inertiajs/vue3';

defineProps([
    'id'
])
</script>