<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    projects: Array
});

 
</script>

<template>
    <Head title="Welcome" />

    <div class="">
        <div v-if="canLogin" class="p-4 border border-black  w-full">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="font-semibold ">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="">Register</Link>
            </template>
        </div>

       <div class="mt-4 mx-4">
        <div class="projects-section"></div>


        <div class="search-projects-section mt-8">

        </div>
            <h2 class="text-xl font-bold mb-4">Meus Projetos</h2>
            <input type="text" v-model="searchQuery" placeholder="Procurar por Projetos" class="border p-2 w-full mb-4" />
            <ul>
                <li v-for="project in userProjects" :key="project.id" class="mb-2">
                    <Link :href="route('projects.show', project.id)" class="text-blue-500 hover:underline">
                        {{ project.name }}
                    </Link>
                </li>
            </ul>


            <div class="flex flex-wrap -mx-2">
                <div v-for="project in projects" :key="project.id" class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img :src="project.image" alt="Project Image" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ project.name }}</h3>
                            <p class="text-gray-600 mb-4">{{ project.description }}</p>
                            <Link :href="route('projects.show', project.id)" class="text-blue-500 hover:underline">View Project</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         
       
    </div>
</template>

<style>

</style>
