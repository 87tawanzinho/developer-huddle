<template>
    <div class="flex flex-col bg-gray-50 text-gray-900">
        <!-- Topbar for mobile -->
        <div v-if="$page.props.auth.user" class="mb-12 md:hidden bg-white shadow-lg p-4 flex justify-between items-center fixed top-0 left-0 right-0 z-10">
            <Icon icon="mdi:cat" class="text-3xl text-blue-600" />
            <span class="text-lg font-semibold text-gray-800">Reunião dos Devs (Versão Beta)</span>
            <button @click="toggleMenu" class="text-gray-600">
                <Icon icon="mdi:menu" class="text-2xl" />
            </button>
        </div>

        <!-- Dropdown for mobile -->
        <div v-if="menuOpen" class="md:hidden bg-white shadow-lg p-4 fixed top-16 left-0 right-0 z-10">
            <nav class="flex flex-col w-full gap-4">
                <Link
                    :href="route('projects.index')"
                    class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:home-outline" class="text-2xl text-blue-500" />
                    <span>Início</span>
                </Link>
                <Link
                    :href="route('dashboard')"
                    class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:account-outline" class="text-2xl text-blue-500" />
                    <span>Perfil</span>
                </Link>
                <Link
                    :href="route('prices')"
                    class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:currency-usd" class="text-2xl text-blue-500" />
                    <span>Planos</span>
                </Link>
            </nav>
        </div>

        <!-- Sidebar for desktop -->
        <div
            v-if="$page.props.auth.user"
            class="hidden md:flex w-64 bg-white shadow-lg h-screen p-6 flex-col items-center gap-8"
        >
            <!-- Logo/Icon -->
            <div class="flex flex-col items-center gap-2">
                <Icon icon="mdi:cat" class="text-6xl text-blue-600" />
                <span class="text-xl text-center font-semibold text-gray-800 tracking-wide">
                    Reunião dos Devs (Versão Beta)
                </span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col w-full gap-4">
                <Link
                    :href="route('projects.index')"
                    class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:home-outline" class="text-2xl text-blue-500" />
                    <span>Início</span>
                </Link>
                <Link
                    :href="route('dashboard')"
                    class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:account-outline" class="text-2xl text-blue-500" />
                    <span>Perfil</span>
                </Link>
                <Link
                    :href="route('prices')"
                    class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:currency-usd" class="text-2xl text-blue-500" />
                    <span>Planos</span>
                </Link>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 mt-16 md:mt-0">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { ref } from 'vue';

const menuOpen = ref(false);

function toggleMenu() {
    menuOpen.value = !menuOpen.value;
}
</script>
