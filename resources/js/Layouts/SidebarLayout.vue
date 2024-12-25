<template>
      <div class="flex min-h-screen bg-gray-50 text-gray-900">
    <div v-if="$page.props.auth.user" class="p-6 border-r flex flex-col gap-4 items-center">
      <Icon icon="openmoji:cat" class="text-6xl text-blue-600" />
      <ElText class="text-2xl font-semibold text-gray-800 border-b-4">Reunião dos Devs</ElText>
      <Link :href="route('home')" class="text-lg font-medium hover:text-blue-600 transition duration-300">
        <ElText>Início</ElText>
      </Link>
      <Link :href="route('dashboard')" class="text-lg font-medium hover:text-blue-600 transition duration-300">
        <ElText>Perfil</ElText>
      </Link>
    </div>
    
    <slot />
    </div>
</template>



<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
</script>