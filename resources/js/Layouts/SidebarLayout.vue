<template>
    <div class="flex flex-col bg-gray-50 text-gray-900">
        <!-- Topbar for mobile -->
        <div
            v-if="$page.props.auth.user"
            class="mb-12 lg:hidden bg-white shadow-md p-4 flex justify-between items-center fixed top-0 left-0 right-0 z-10"
        >
            <div class="flex items-center gap-2">
                <Icon icon="mdi:cat" class="text-xl text-blue-600" />
                <span class="text-base font-medium text-gray-800"
                    >Reunião dos Devs</span
                >
            </div>
            <div class="flex items-center gap-3">
                <div @click="inviteStore.isOpen = !inviteStore.isOpen">
                    <Icon
                        icon="mi:email"
                        class="text-xl text-gray-700 relative"
                    />
                    <span
                        v-if="invitations"
                        class="absolute right-9 top-[9px] flex items-center justify-center bg-red-800 text-white text-xs font-bold rounded-full h-4 w-4"
                    >
                        {{ invitations }}
                    </span>
                </div>
                <button @click="toggleMenu" class="text-gray-600">
                    <Icon icon="mi:menu" class="text-xl text-gray-700" />
                </button>
            </div>
        </div>

        <!-- Dropdown for mobile -->
        <div
            v-if="menuOpen"
            class="lg:hidden bg-white shadow-lg p-4 fixed top-16 left-0 right-0 z-10"
        >
            <nav class="flex flex-col w-full gap-3">
                <!-- <Link
                    :href="route('feed')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon
                        icon="material-symbols:feed-outline"
                        class="text-xl text-blue-600"
                    />
                    <span>Feed</span>
                </Link> -->

                <Link
                    :href="route('projects.index')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mi:folder" class="text-xl text-blue-600" />
                    <span>Meus Projetos</span>
                </Link>

                <Link
                    :href="route('profile.show')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mi:user" class="text-xl text-blue-600" />
                    <span>Perfil</span>
                </Link>

                <Link
                    :href="route('prices')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon
                        icon="qlementine-icons:money-16"
                        class="text-xl text-blue-600"
                    />
                    <span>Planos</span>
                </Link>
            </nav>
        </div>

        <!-- Sidebar for desktop -->
        <div
            v-if="$page.props.auth.user"
            class="hidden lg:flex w-60 bg-white shadow-md h-full p-5 flex-col items-center gap-6"
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
                <!-- <Link
                    :href="route('feed')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon
                        icon="material-symbols:feed-outline"
                        class="text-xl text-blue-600"
                    />
                    <span>Feed</span>
                </Link> -->

                <Link
                    :href="route('projects.index')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mi:folder" class="text-xl text-blue-600" />
                    <span>Meus Projetos</span>
                </Link>

                <div
                    @click="inviteStore.isOpen = !inviteStore.isOpen"
                    class="relative flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon
                        icon="mi:email"
                        class="text-xl text-blue-600 relative"
                    />
                    <span
                        v-if="invitations"
                        class="absolute left-0 top-[4px] flex items-center justify-center bg-red-800 text-white text-xs font-bold rounded-full h-4 w-4"
                    >
                        {{ invitations }}
                    </span>
                    <span>Convites</span>
                </div>

                <Link
                    :href="route('profile.show')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon icon="mi:user" class="text-xl text-blue-600" />
                    <span>Perfil</span>
                </Link>

                <Link
                    :href="route('prices')"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon
                        icon="qlementine-icons:money-16"
                        class="text-xl text-blue-600"
                    />
                    <span>Planos</span>
                </Link>

                <a
                    href="https://discord.gg/R3N7sKY5MA"
                    target="_blank"
                    class="flex items-center gap-2 p-2 w-full text-base font-medium text-gray-600 rounded-md hover:bg-blue-50 hover:text-blue-600 transition"
                >
                    <Icon
                        icon="arcticons:cbc-news"
                        class="text-xl text-blue-600"
                    />
                    <span>Discord</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 mt-12 md:mt-0">
            <slot />
        </div>

        <Invites />
    </div>
</template>

<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { ref } from "vue";
import { useInvitesStore } from "@/stores/useInviteStore";
import Invites from "@/Components/Invites.vue";
import { computed } from "vue";
import { useDark, useToggle } from "@vueuse/core";

const isDark = useDark();
const toggleDark = useToggle(isDark);

const menuOpen = ref(false);
const inviteStore = useInvitesStore();

const invitations = computed(() => inviteStore.invitations.length);

console.log(invitations);
function toggleMenu() {
    menuOpen.value = !menuOpen.value;
}
</script>
