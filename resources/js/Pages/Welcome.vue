<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import {ref, defineProps} from 'vue';
import { Icon } from '@iconify/vue';
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    projects: Array
});

const searchQuery = ref('')

 
</script>

<template>
    <Head title="Welcome" />

    <div class="flex">
        <div v-if="canLogin" class="p-4 border-r flex flex-col gap-1 border-gray-400  h-screen">
            <Link v-if="$page.props.auth.user" :href="route('home')" class="border-b  border-blue-800 hover:text-blue-600">Início</Link>
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="hover:text-blue-600">Perfil</Link>

            <template v-else>
            <Link :href="route('login')" class="font-semibold hover:text-blue-600">Log in</Link>

            <Link v-if="canRegister" :href="route('register')" class="hover:text-blue-600">Register</Link>
            </template>
        </div>

       <div class="mt-4 mx-4">
        <div class="projects-section"></div>


        <div class="search-projects-section mt-8">

        </div>
            <h2 class="text-2xl font-bold text-center">Meus Projetos</h2>
            <div class="flex justify-center items-center py-4">
                <input type="text" v-model="searchQuery" placeholder="Procurar por Projetos" class="border p-3 w-full  rounded-lg shadow-sm" />
                <Icon icon="flat-color-icons:plus" class="text-[2rem] ml-4 hover:text-blue-600 cursor-pointer transition-colors duration-300"/>
            </div>

            <div class="flex flex-wrap -mx-2 ">
            <div v-for="project in projects" :key="project.id" class="w-full   sm:w-1/2 lg:w-1/3 px-4 mb-6 ">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300  relative  ">
                <img :src="project.image" alt="Project Image" class="w-full h-48 object-cover">
                <div class="p-6  min-h-[16rem] max-h-[16rem] h-[16rem]">
                    <h3 class="text-xl font-semibold mb-3">{{ project.name }}</h3>
                    <p class="text-gray-700 mb-4">{{ project.description }}</p>
                    <Link :href="route('projects.show', project.id)" class="text-white bg-blue-600 rounded-lg  p-2 hover:underline absolute bottom-4">Ver Projeto</Link>
                </div>
                </div>
            </div>
            </div>
        </div>

         
       
    </div>
</template>

<style>

</style>
