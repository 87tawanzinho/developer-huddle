<template>
    <Head :title="`Projeto ${id}`" />
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <SidebarLayout />

        <!-- Main Content -->
        <div class="flex-1 flex   justify-center p-6 sm:p-12">
            <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 sm:p-10 transform transition-all hover:shadow-2xl">
                <!-- Project Header -->
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <!-- Project Image -->
                    <img 
                        :src="`/storage/${project.image}`" 
                        alt="Imagem do Projeto"
                        class="rounded-full w-24 h-24 sm:w-32 sm:h-32 object-cover border border-gray-200 shadow-sm"
                    />

                    <!-- Project Info -->
                    <div class="text-center sm:text-left">
                        <h1 class="text-3xl font-bold text-gray-800 leading-tight">
                            {{ project.name }}
                        </h1>
                        <p class="mt-2 text-gray-500" v-if="!showFullDescription">
                           {{ truncatedDescription }}
                           <span v-if="isTruncated" @click="showFullDescription = true" class="text-blue-500 cursor-pointer">Ver mais</span>
                        </p>
                        <p class="mt-2 text-gray-500" v-else>
                           {{ project.description }}
                           <span @click="showFullDescription = false" class="text-blue-500 cursor-pointer">Ver menos</span>
                        </p>
                    </div>
                </div>

                <!-- Project Dates -->
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div class="flex items-center gap-4 p-4 bg-green-50 rounded-lg border border-green-200">
                        <Icon icon="mdi:calendar-start" class="w-6 h-6 text-green-600" />
                        <div>
                            <span class="text-sm font-medium text-gray-600">Início</span>
                            <p class="text-lg font-semibold text-gray-800">{{ formatDate(project.start_date) }}</p>
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="flex items-center gap-4 p-4 bg-red-50 rounded-lg border border-red-200">
                        <Icon icon="mdi:calendar-end" class="w-6 h-6 text-red-600" />
                        <div>
                            <span class="text-sm font-medium text-gray-600">Fim</span>
                            <p class="text-lg font-semibold text-gray-800">{{ formatDate(project.end_date) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue';
import { Head } from '@inertiajs/vue3';
import { formatDate } from './utils/formatDate';
import { Icon } from '@iconify/vue';

const props = defineProps([
    'id',
    'project'
]);

import { ref, computed } from 'vue';

const showFullDescription = ref(false);

const truncatedDescription = computed(() => {
    const maxLength = 100;
    if (props.project.description.length > maxLength) {
        return props.project.description.substring(0, maxLength) + '...';
    }
    return props.project.description;
});

const isTruncated = computed(() => {
    return props.project.description.length > 100;
});
</script>
