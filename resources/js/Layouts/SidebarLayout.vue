<template>
    <div class="flex flex-col bg-gray-50 text-gray-900">
        <!-- Topbar for mobile -->
        <div v-if="$page.props.auth.user" class="mb-12 md:hidden bg-white shadow-md p-3 flex justify-between items-center fixed top-0 left-0 right-0 z-10">
            <Icon icon="mdi:cat" class="text-xl text-blue-600" />
            <span class="text-base font-medium text-gray-800">Reunião dos Devs</span>
            <button @click="toggleMenu" class="text-gray-600">
                <Icon icon="mdi:menu" class="text-xl text-gray-700" />
            </button>
        </div>

        <!-- Dropdown for mobile -->
        <div v-if="menuOpen" class="md:hidden bg-white shadow-lg p-4 fixed top-16 left-0 right-0 z-10">
            <nav class="flex flex-col w-full gap-3">
                <Link 
                    :href="route('home')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:timeline" class="text-xl text-blue-600" />
                    <span>Feed</span>
                </Link>

                <Link 
                    :href="route('home')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:folder-outline" class="text-xl text-blue-600" />
                    <span>Meus Projetos</span>
                </Link>

                <Link 
                    :href="route('dashboard')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:account-outline" class="text-xl text-blue-600" />
                    <span>Perfil</span>
                </Link>

                <Link 
                    :href="route('prices')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:currency-usd" class="text-xl text-blue-600" />
                    <span>Planos</span>
                </Link>
            </nav>
        </div>

        <!-- Sidebar for desktop -->
        <div 
            v-if="$page.props.auth.user" 
            class="hidden md:flex w-60 bg-white shadow-md h-screen p-5 flex-col items-center gap-6"
        >
            <!-- Logo/Icon -->
            <div class="flex flex-col items-center gap-1">
                <Icon icon="mdi:cat" class="text-4xl text-blue-600" />
                <span class="text-lg text-center font-medium text-gray-800">
                    Reunião dos Devs
                </span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col w-full gap-3">
                <Link 
                    :href="route('home')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:timeline" class="text-xl text-blue-600" />
                    <span>Feed</span>
                </Link>

                <Link 
                    :href="route('home')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:folder-outline" class="text-xl text-blue-600" />
                    <span>Meus Projetos</span>
                </Link>

                <Link 
                    :href="route('dashboard')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:account-outline" class="text-xl text-blue-600" />
                    <span>Perfil</span>
                </Link>

                <Link 
                    :href="route('prices')" 
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mdi:currency-usd" class="text-xl text-blue-600" />
                    <span>Planos</span>
                </Link>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 mt-12 md:mt-0">
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
