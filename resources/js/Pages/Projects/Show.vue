<template>
    <Head :title="`Projeto ${project.name}`" />
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <SidebarLayout />

        <!-- Main Content -->
        <div class="flex-1 flex justify-center p-6 sm:p-12">
            <div class="bg-white rounded-lg shadow-lg max-w-4xl relative w-full p-8 sm:p-10 transform transition-all hover:shadow-2xl">
                <!-- Project Header -->
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <!-- Project Image -->
                    <img
                        :src="`/storage/${project.cover_path}`"
                        alt="Imagem do Projeto"
                        class="rounded-full w-24 h-24 sm:w-32 sm:h-32 object-cover border border-gray-200 shadow-sm"
                    />

                    <!-- Project Info -->
                    <div class="text-center sm:text-left w-full">
                        <div class="flex items-center justify-between">
                            <h1 class="text-3xl font-bold text-gray-800 leading-tight">
                                {{ project.name }}
                            </h1>

                            <div v-if="$page.props.auth.user.id === project.owner[0].id" class="absolute right-8 top-2 sm:right-10">
                                <Icon
                                    @click="deleteProjectIfOwner(project.id)"
                                    icon="mdi:delete"
                                    class="w-6 h-6 cursor-pointer text-red-600 transition-opacity duration-200 hover:opacity-75"
                                />
                            </div>
                        </div>

                        <!-- Description Section -->
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

                <div class="flex justify-between items-center">
                    <div class="mt-8 flex items-center gap-2">
                        <div v-for="user in project.users" :key="user.name" class="flex items-center gap-2">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-sm text-white bg-gradient-to-r from-blue-400 to-blue-600"
                            >
                                {{ user.name }}
                            </span>
                        </div>
                    </div>

                    <ElButton v-if="tasks.length" @click="drawer = true" class="flex items-center gap-2 mt-8" type="primary">
                        <Icon icon="mdi:plus" class="mr-2 text-xl"/>
                        Criar uma nova tarefa
                    </ElButton>
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

                <div>
                    <div v-if="!tasks.length" class="mt-24 flex flex-col gap-4 justify-center pb-48 items-center h-full">
                        <ElText size="large">Você ainda não possui tarefas</ElText>
                        <ElButton @click="drawer = true" class="flex items-center gap-2" type="primary">
                            <Icon icon="mdi:plus" class="mr-2 text-xl"/>
                            Criar uma nova tarefa
                        </ElButton>
                    </div>
                    <div v-else>
                        <p class="text-center mt-4 text-2xl text-gray-400">Tarefas</p>

                        <div class="flex flex-col overflow-auto max-h-96">
                            <div v-for="task in tasks" :key="task.id" class="gap-4 border mt-4 bg-white p-6 rounded-lg shadow-lg mb-4 hover:shadow-xl transition-shadow duration-300">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <Icon
                                            icon="mdi:delete"
                                            class="w-6 h-6 cursor-pointer text-red-600 transition-opacity duration-200 hover:opacity-75"
                                            @click="deleteTask(task.id)"
                                        />
                                        <h3 class="text-xl font-semibold text-gray-800">{{ task.title }}</h3>
                                    </div>
                                    <span :class="{
                                        'text-green-500': task.status === 'done',
                                        'text-blue-500': task.status === 'doing',
                                        'text-red-500': task.status === 'todo'
                                    }" class="text-sm font-medium flex items-center gap-2">
                                        <Icon v-if="task.status === 'done'" icon="mdi:check-circle" class="w-5 h-5" />
                                        <Icon v-if="task.status === 'doing'" icon="mdi:progress-clock" class="w-5 h-5" />
                                        <Icon v-if="task.status === 'todo'" icon="mdi:clipboard-outline" class="w-5 h-5" />
                                        {{ translatedStatus[task.status] }}
                                    </span>
                                </div>
                                <p class="text-gray-600 mt-2 cursor-pointer" @click="changeDescriptionDrawer(task.description, task.id)">{{ task.description }}</p>

                                <div class="flex justify-between mt-4">
                                    <div class="flex items-center gap-2">

                                        <span class="px-3 py-1 rounded-full text-sm text-white bg-gradient-to-r from-blue-400 to-blue-600 flex items-center gap-2">
                                            <Icon icon="mdi:account" class="w-4 h-4" />
                                            {{ task.responsible.name }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span :class="{
                                            'bg-green-500': task.priority === 'low',
                                            'bg-yellow-500': task.priority === 'medium',
                                            'bg-red-500': task.priority === 'high'
                                        }" class="px-3 py-1 rounded-full text-sm border-b text-white flex items-center gap-2">
                                            <Icon v-if="task.priority === 'low'" icon="mdi:flag-outline" class="w-4 h-4" />
                                            <Icon v-if="task.priority === 'medium'" icon="mdi:flag-outline" class="w-4 h-4" />
                                            <Icon v-if="task.priority === 'high'" icon="mdi:flag" class="w-4 h-4" />
                                            {{ translatedPriority[task.priority] }}
                                        </span>
                                    </div>
                                </div>
                                <ElProgress :percentage="task.progress" class="mt-4"/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer -->
                <ElDrawer v-model="drawer" title="Nova Tarefa" size="50%" :withHeader="false">
                    <div class="text-center">
                        <ElText>Criar nova Tarefa</ElText>
                    </div>
                    <div class="p-6">
                        <form class="space-y-6">
                            <!-- Título -->
                            <div class="space-y-2">
                                <ElText class="text-gray-700">Título da Tarefa</ElText>
                                <ElInput
                                    v-model="create.taskTitle"
                                    placeholder="Digite um título descritivo"
                                    :prefix-icon="() => h(Icon, { icon: 'mdi:format-title' })"
                                />
                            </div>

                            <!-- Descrição -->
                            <div class="space-y-2">
                                <ElText class="text-gray-700">Descrição</ElText>
                                <ElInput
                                    v-model="create.taskDescription"
                                    type="textarea"
                                    :rows="4"
                                    placeholder="Descreva os detalhes da tarefa"
                                />
                            </div>

                            <div class="space-y-2">
                                <ElText class="text-gray-700">Responsável</ElText>
                                <ElSelect v-model="create.responsible" placeholder="Selecione um responsável" class="w-full">
                                    <ElOption v-for="user in users" :key="user" :value="user.name" :label="user.name" />
                                </ElSelect>
                            </div>

                            <!-- Prioridade e Status -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <ElText class="text-gray-700">Prioridade</ElText>
                                    <ElSelect v-model="create.priority" class="w-full">
                                        <ElOption value="low" label="Baixa">
                                            <div class="flex items-center">
                                                <Icon icon="mdi:flag-outline" class="mr-2 text-green-500" />
                                                Baixa
                                            </div>
                                        </ElOption>
                                        <ElOption value="medium" label="Média">
                                            <div class="flex items-center">
                                                <Icon icon="mdi:flag" class="mr-2 text-yellow-500" />
                                                Média
                                            </div>
                                        </ElOption>
                                        <ElOption value="high" label="Alta">
                                            <div class="flex items-center">
                                                <Icon icon="mdi:flag" class="mr-2 text-red-500" />
                                                Alta
                                            </div>
                                        </ElOption>
                                    </ElSelect>
                                </div>

                                <div class="space-y-2">
                                    <ElText class="text-gray-700">Status</ElText>
                                    <ElSelect v-model="create.status" class="w-full">
                                        <ElOption value="todo" label="A fazer">
                                            <div class="flex items-center">
                                                <Icon icon="mdi:clipboard-outline" class="mr-2 text-gray-500" />
                                                A fazer
                                            </div>
                                        </ElOption>
                                        <ElOption value="doing" label="Em andamento">
                                            <div class="flex items-center">
                                                <Icon icon="mdi:progress-clock" class="mr-2 text-blue-500" />
                                                Em andamento
                                            </div>
                                        </ElOption>
                                        <ElOption value="done" label="Concluído">
                                            <div class="flex items-center">
                                                <Icon icon="mdi:check-circle" class="mr-2 text-green-500" />
                                                Concluído
                                            </div>
                                        </ElOption>
                                    </ElSelect>
                                </div>
                            </div>

                            <!-- Progresso -->
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <ElText class="text-gray-700">Progresso</ElText>
                                    <span class="text-sm text-gray-500">{{ progress }}%</span>
                                </div>
                                <ElSlider v-model="create.progress" :step="10" show-stops />
                            </div>

                            <!-- Botões -->
                            <div class="flex justify-end space-x-4 pt-4">
                                <ElButton @click="drawer = false">Cancelar</ElButton>
                                <ElButton type="primary" class="flex items-center" @click="createTask">
                                    <Icon icon="mdi:check" class="mr-2" />
                                    Criar Tarefa
                                </ElButton>
                            </div>
                        </form>
                    </div>
                </ElDrawer>

                <ElDrawer v-model="descriptionDrawer" title="Mudança de Descrição " size="50%" :withHeader="false" >
                                        <div class="p-6 space-y-6">
                                            <div class=" text-gray-700 font-semibold flex items-center justify-center gap-2">
                                                <p>Mudança de Descrição</p>
                                                <Icon icon="mdi:alert-circle-outline" class="text-xl"/>


                                                                                        </div>
                                            <div>
                                                <ElText class="text-gray-700 font-semibold">Sua antiga descrição:</ElText>
                                                <p class="border rounded-md p-2 text-gray-600 text-sm mt-1 bg-gray-200">{{ activeDescriptionForCompare }}</p>

                                            </div>
                                            <div>
                                                <ElText class="text-gray-700 font-semibold">Sua nova descrição:</ElText>
                                                <ElInput
                                                    v-model="newDescription"
                                                    type="textarea"
                                                    :rows="4"
                                                    placeholder="Descreva os detalhes da tarefa"
                                                    class="mt-2"
                                                />
                                            </div>
                                            <div class="flex justify-end space-x-4 pt-4">
                                                <ElButton @click="descriptionDrawer = false">Cancelar</ElButton>
                                                <ElButton type="primary" class="flex items-center" @click="updateTaskDescription">
                                                    <Icon icon="mdi:check" class="mr-2" />
                                                    Atualizar Descrição
                                                </ElButton>
                                            </div>
                                        </div>
                                    </ElDrawer>
            </div>
        </div>
    </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue';
import { Head } from '@inertiajs/vue3';
import { formatDate } from '../utils/formatDate.js';
import { Icon } from '@iconify/vue';
import { h } from 'vue';
import { router } from '@inertiajs/vue3';
const props = defineProps([
    'id',
    'project',
    'users',
    'tasks'
]);

import { ref, computed } from 'vue';

const drawer = ref(false);
const showFullDescription = ref(false);

const create = ref({
    taskTitle: '',
    taskDescription: '',
    priority: 'low',
    responsible: '',
    status: 'todo',
    progress: 0,
});

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

import { ElButton, ElDrawer, ElInput, ElMessageBox, ElOption, ElSelect, ElText, ElProgress, ElSlider } from 'element-plus';
import axios from 'axios';

const translatedPriority = computed(() => ({
    low: 'Baixa',
    medium: 'Média',
    high: 'Alta',
}));

const translatedStatus = computed(() => ({
    done: 'Concluído',
    doing: 'Em andamento',
    todo: 'A fazer',
}));

const deleteProjectIfOwner = (id) => {
    ElMessageBox.confirm('Tem certeza que deseja excluir este projeto?', 'Confirmação', {
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        type: 'warning',
    }).then(() => {
        router.delete(route('projects.delete', { id }));
    }).catch(() => {
        // Handle cancel action
    });
};

const createTask = () => {
    router.post(route('projects.createTask'), {
        title: create.value.taskTitle,
        description: create.value.taskDescription,
        priority: create.value.priority,
        responsible: create.value.responsible,
        status: create.value.status,
        progress: create.value.progress,
        project_id: props.project.id,
    });
    drawer.value = false;
};

const deleteTask = (id) => {
    ElMessageBox.confirm('Tem certeza que deseja excluir esta tarefa?', 'Confirmação', {
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        type: 'warning',
    }).then(() => {
        router.delete(route('projects.deleteTask', { id }));
    }).catch(() => {
        // Handle cancel action
    });
};

const descriptionDrawer = ref(false);
const activeDescriptionForCompare = ref('');
const newDescription = ref('');
const currentTaskId = ref(null);

function changeDescriptionDrawer(description, taskId) {
    descriptionDrawer.value = true;
    activeDescriptionForCompare.value = description;
    currentTaskId.value = taskId;
}

function updateTaskDescription() {
    if (newDescription.value !== '') {
        try {
            router.put(route('projects.updateTaskDescription', { projectId: props.project.id, taskId: currentTaskId.value }), {
                description: newDescription.value
            });
            newDescription.value = '';
        } catch (error) {
            console.log(error);
        }
    } else {
        ElMessageBox.alert('A descrição não pode ser vazia', 'Erro', {
            confirmButtonText: 'Ok',
            type: 'error',
        });
    }
    descriptionDrawer.value = false;
}
</script>
