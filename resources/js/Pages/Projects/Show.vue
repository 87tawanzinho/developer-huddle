<template>
    <Head :title="`Projeto ${project.name}`" />
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <SidebarLayout />
        <!-- ////////////// TODO CLICA NA TAREFA E TRANSFORMA EM CARTA/FOLDER -->
        <!-- Main Content -->
        <div class="flex-1 flex justify-center w-full mt-12 sm:mt-0 sm:p-12">
            <div
                class="bg-white rounded-lg shadow-lg max-w-5xl relative w-full p-8 sm:p-10 transform transition-all hover:shadow-2xl"
            >
                <!-- Project Header -->
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <!-- Project Image -->
                    <img
                        :src="`/storage/${project.cover_path}`"
                        alt="Imagem do Projeto"
                        class="rounded-full w-32 h-32 sm:w-32 sm:h-32 object-cover border border-gray-200 shadow-sm"
                    />

                    <!-- Project Info -->
                    <div class="text-center sm:text-left w-full">
                        <div class="flex items-center justify-between">
                            <h1
                                class="text-3xl font-bold text-gray-800 leading-tight"
                            >
                                {{ project.name }}
                            </h1>

                            <div
                                v-if="
                                    $page.props.auth.user.id ===
                                    project.owner[0].id
                                "
                                class="absolute right-8 top-12 sm:right-10"
                            >
                                <Icon
                                    @click="deleteProjectIfOwner(project.id)"
                                    icon="streamline:delete-1"
                                    class="text-lg cursor-pointer text-gray-600 transition-opacity duration-200 hover:opacity-75"
                                />
                            </div>
                        </div>

                        <!-- Description Section -->
                        <p
                            class="mt-2 text-gray-500 text-start"
                            v-if="!showFullDescription"
                        >
                            {{ truncatedDescription }}
                            <span
                                v-if="isTruncated"
                                @click="showFullDescription = true"
                                class="text-blue-500 cursor-pointer"
                                >Ver mais</span
                            >
                        </p>
                        <p class="mt-2 text-gray-500 text-start" v-else>
                            {{ project.description }}
                            <span
                                @click="showFullDescription = false"
                                class="text-blue-500 cursor-pointer"
                                >Ver menos</span
                            >
                        </p>
                    </div>
                </div>

                <!-- Users & Create Task Button -->
                <div class="flex justify-between items-center">
                    <div class="mt-8 flex items-center gap-2">
                        <ElDropdown class="flex items-center">
                            <ElButton type="">
                                <svg
                                    class="mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 36 36"
                                >
                                    <path
                                        fill="#535252"
                                        d="M17.9 17.3c2.7 0 4.8-2.2 4.8-4.9s-2.2-4.8-4.9-4.8S13 9.8 13 12.4c0 2.7 2.2 4.9 4.9 4.9m-.1-7.7q.15 0 0 0c1.6 0 2.9 1.3 2.9 2.9s-1.3 2.8-2.9 2.8S15 14 15 12.5c0-1.6 1.3-2.9 2.8-2.9"
                                        class="clr-i-outline clr-i-outline-path-1"
                                    />
                                    <path
                                        fill="#535252"
                                        d="M32.7 16.7c-1.9-1.7-4.4-2.6-7-2.5h-.8q-.3 1.2-.9 2.1c.6-.1 1.1-.1 1.7-.1c1.9-.1 3.8.5 5.3 1.6V25h2v-8z"
                                        class="clr-i-outline clr-i-outline-path-2"
                                    />
                                    <path
                                        fill="#535252"
                                        d="M23.4 7.8c.5-1.2 1.9-1.8 3.2-1.3c1.2.5 1.8 1.9 1.3 3.2c-.4.9-1.3 1.5-2.2 1.5c-.2 0-.5 0-.7-.1c.1.5.1 1 .1 1.4v.6c.2 0 .4.1.6.1c2.5 0 4.5-2 4.5-4.4c0-2.5-2-4.5-4.4-4.5c-1.6 0-3 .8-3.8 2.2c.5.3 1 .7 1.4 1.3"
                                        class="clr-i-outline clr-i-outline-path-3"
                                    />
                                    <path
                                        fill="#535252"
                                        d="M12 16.4q-.6-.9-.9-2.1h-.8c-2.6-.1-5.1.8-7 2.4L3 17v8h2v-7.2c1.6-1.1 3.4-1.7 5.3-1.6c.6 0 1.2.1 1.7.2"
                                        class="clr-i-outline clr-i-outline-path-4"
                                    />
                                    <path
                                        fill="#535252"
                                        d="M10.3 13.1c.2 0 .4 0 .6-.1v-.6c0-.5 0-1 .1-1.4c-.2.1-.5.1-.7.1c-1.3 0-2.4-1.1-2.4-2.4S9 6.3 10.3 6.3c1 0 1.9.6 2.3 1.5c.4-.5 1-1 1.5-1.4c-1.3-2.1-4-2.8-6.1-1.5s-2.8 4-1.5 6.1c.8 1.3 2.2 2.1 3.8 2.1"
                                        class="clr-i-outline clr-i-outline-path-5"
                                    />
                                    <path
                                        fill="#535252"
                                        d="m26.1 22.7l-.2-.3c-2-2.2-4.8-3.5-7.8-3.4c-3-.1-5.9 1.2-7.9 3.4l-.2.3v7.6c0 .9.7 1.7 1.7 1.7h12.8c.9 0 1.7-.8 1.7-1.7v-7.6zm-2 7.3H12v-6.6c1.6-1.6 3.8-2.4 6.1-2.4c2.2-.1 4.4.8 6 2.4z"
                                        class="clr-i-outline clr-i-outline-path-6"
                                    />
                                    <path fill="none" d="M0 0h36v36H0z" />
                                </svg>
                                {{ project.users.length }}
                            </ElButton>
                            <template #dropdown>
                                <div
                                    v-for="user in project.users"
                                    :key="user.name"
                                >
                                    <ElDropdownItem
                                        :class="[
                                            user.pivot.role === 'owner' &&
                                                'bg-gray-200',
                                        ]"
                                    >
                                        <svg
                                            class="mr-1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="16"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                fill="none"
                                                stroke="#535252"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="0.7"
                                                d="M21 22c0-4.418-3.626-8-8.1-8h-1.8C6.626 14 3 17.582 3 22m9-11a4 4 0 0 1-4-4V6a4 4 0 1 1 8 0v1a4 4 0 0 1-4 4"
                                            />
                                        </svg>
                                        {{ user.name }}</ElDropdownItem
                                    >
                                </div>
                            </template>
                        </ElDropdown>

                        <ElText style="margin-left: 12px">{{
                            translatedProjectType[project.project_type]
                        }}</ElText>
                    </div>

                    <ElButton
                        v-if="tasks.length"
                        @click="drawer = true"
                        class="flex items-center gap-2 mt-8"
                        type="primary"
                        style="font-size: 16px"
                        round
                    >
                        <Icon icon="mdi:plus" class="mr-1 text-2xl" />
                        Criar
                    </ElButton>
                </div>

                <!-- Project Dates -->
                <div class="mt-8 flex items-center gap-2 sm:gap-4 mb-4">
                    <div
                        class="flex flex-1 w-1/2 items-center px-2 p-1 gap-4 text-sm rounded-lg border border-blue-400"
                    >
                        <Icon
                            icon="mdi:calendar-start"
                            class="w-6 h-6 text-gray-600"
                        />
                        <div>
                            <span class="text-sm text-gray-600">Início</span>
                            <p class="text-gray-600">
                                {{ formatDate(project.start_date) }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex flex-1 w-1/2 items-center px-2 p-1 gap-4 text-sm rounded-lg border border-blue-400"
                    >
                        <Icon
                            icon="mdi:calendar-end"
                            class="w-6 h-6 text-gray-600"
                        />
                        <div>
                            <span class="text-sm text-gray-600">Fim</span>
                            <p class="text-gray-600">
                                {{ formatDate(project.end_date) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tasks Section -->
                <div>
                    <div
                        v-if="!tasks.length"
                        class="mt-24 flex flex-col gap-4 justify-center pb-48 items-center h-full"
                    >
                        <ElText size="large"
                            >Você ainda não possui tarefas</ElText
                        >
                        <ElButton
                            @click="drawer = true"
                            class="flex items-center gap-2"
                            type="primary"
                        >
                            <Icon icon="mdi:plus" class="mr-2 text-xl" />
                            Criar
                        </ElButton>
                    </div>

                    <div v-else>
                        <div
                            class="flex items-center justify-between gap-2 py-2"
                        >
                            <div class="flex">
                                <ElButton disabled type="info" plain round
                                    >Prioridade</ElButton
                                >
                                <ElButton disabled type="info" round plain
                                    >Status</ElButton
                                >
                                <ElButton disabled type="info" round plain
                                    >Responsável</ElButton
                                >
                            </div>
                            <ElButton
                                plain
                                circle
                                full-circle
                                @click="shrink = !shrink"
                                ><Icon icon="lucide:shrink"
                            /></ElButton>
                        </div>

                        <div class="flex flex-col overflow-auto max-h-96">
                            <div
                                v-show="shrink"
                                v-for="task in tasks"
                                :key="task.id"
                                :class="[
                                    'gap-4 border  mt-4 bg-white  p-3 sm:p-4 rounded-lg shadow-lg mb-4 hover:shadow-xl transition-shadow duration-300',
                                    task.progress === 100 ? 'bg-blue-50' : '',
                                ]"
                            >
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <Icon
                                            icon="material-symbols:delete-outline"
                                            class="w-6 h-6 cursor-pointer text-gray-600 transition-opacity duration-200 hover:opacity-75"
                                            @click="deleteTask(task.id)"
                                        />
                                        <h3
                                            class="text-xl font-semibold text-gray-800"
                                        >
                                            {{ task.title }}
                                        </h3>
                                    </div>
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                task.status === 'done',
                                            'text-yellow-600':
                                                task.status === 'in_progress',
                                            'text-purple-600':
                                                task.status === 'todo',
                                        }"
                                        class="text-sm font-medium flex items-center gap-2"
                                    >
                                        <Icon
                                            v-if="task.status === 'done'"
                                            icon="mdi:check-circle"
                                            class="w-5 h-5"
                                        />
                                        <Icon
                                            v-if="task.status === 'in_progress'"
                                            icon="mdi:progress-clock"
                                            class="w-5 h-5"
                                        />
                                        <Icon
                                            v-if="task.status === 'todo'"
                                            icon="mdi:clipboard-outline"
                                            class="w-5 h-5"
                                        />
                                        {{ translatedStatus[task.status] }}
                                    </span>
                                </div>
                                <p
                                    class="text-gray-600 text-sm mt-3 cursor-pointer"
                                    @click="
                                        changeDescriptionDrawer(
                                            task.description,
                                            task.id,
                                        )
                                    "
                                >
                                    {{ task.description }}
                                </p>

                                <div class="flex justify-between mt-4">
                                    <div class="flex items-center gap-2">
                                        <ElDropdown
                                            onclick="changeResponsible"
                                            placement="top-start"
                                        >
                                            <ElButton round>
                                                <Icon
                                                    icon="mdi:account"
                                                    class="w-4 h-4 mr-1"
                                                />
                                                {{ task.responsible.name }}
                                            </ElButton>
                                            <template #dropdown>
                                                <div
                                                    v-for="user in project.users"
                                                    :key="user.id || user"
                                                >
                                                    <el-dropdown-item
                                                        @click="
                                                            () => {
                                                                currentTaskId =
                                                                    task.id;
                                                                updateTask(
                                                                    'responsible',
                                                                    user.id,
                                                                );
                                                            }
                                                        "
                                                        >{{
                                                            user.name
                                                        }}</el-dropdown-item
                                                    >
                                                </div>
                                            </template>
                                        </ElDropdown>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span
                                            :class="{
                                                'bg-green-600':
                                                    task.priority === 'low',
                                                'bg-yellow-600':
                                                    task.priority === 'medium',
                                                'bg-red-600':
                                                    task.priority === 'high',
                                            }"
                                            class="px-1 sm:px-3 py-1 rounded-full text-[13px] border-b text-gray-100 flex items-center"
                                        >
                                            <Icon
                                                v-if="task.priority === 'low'"
                                                icon="mdi:flag-outline"
                                                class="w-4 h-4 mr-1"
                                            />
                                            <Icon
                                                v-if="
                                                    task.priority === 'medium'
                                                "
                                                icon="mdi:flag-outline"
                                                class="w-4 h-4 mr-1"
                                            />
                                            <Icon
                                                v-if="task.priority === 'high'"
                                                icon="mdi:flag"
                                                class="w-4 h-4 mr-1"
                                            />
                                            {{
                                                translatedPriority[
                                                    task.priority
                                                ]
                                            }}
                                        </span>
                                    </div>
                                </div>
                                <ElProgress
                                    :percentage="task.progress"
                                    class="mt-4"
                                    @click="
                                        changeProgress(task.progress, task.id)
                                    "
                                />
                            </div>

                            <div
                                v-show="!shrink"
                                class="flex flex-col gap-4 mt-4 justify-center border bg-white p-3 sm:p-4 rounded-lg shadow-lg mb-4 hover:shadow-xl transition-shadow duration-300"
                            >
                                <div
                                    class="border p-1 rounded-lg flex items-center gap-4 w-full"
                                    v-for="task in tasks"
                                    :key="task.id"
                                >
                                    <!-- Foto e nome à esquerda com largura definida -->
                                    <div class="flex items-center gap-2 w-1/4">
                                        <div class="flex items-center gap-2">
                                            <ElDropdown
                                                onclick="changeResponsible"
                                                placement="bottom-start"
                                            >
                                                <img
                                                    class="rounded-full h-8 w-8 object-cover"
                                                    :src="
                                                        task.responsible
                                                            .profile_photo_url
                                                    "
                                                    alt=""
                                                />

                                                <template #dropdown>
                                                    <div
                                                        v-for="user in project.users"
                                                        :key="user.id || user"
                                                    >
                                                        <el-dropdown-item
                                                            @click="
                                                                () => {
                                                                    currentTaskId =
                                                                        task.id;
                                                                    updateTask(
                                                                        'responsible',
                                                                        user.id,
                                                                    );
                                                                }
                                                            "
                                                            >{{
                                                                user.name
                                                            }}</el-dropdown-item
                                                        >
                                                    </div>
                                                </template>
                                            </ElDropdown>
                                        </div>
                                        <ElText class="truncate"
                                            >[{{ task.title }}]</ElText
                                        >
                                    </div>

                                    <!-- ElSlider no meio com largura definida -->
                                    <div class="flex justify-center w-1/2">
                                        <ElSlider
                                            @click="
                                                changeProgress(
                                                    task.progress,
                                                    task.id,
                                                )
                                            "
                                            :show-tooltip="false"
                                            :model-value="task.progress"
                                            class="sliderStyle"
                                        />
                                    </div>

                                    <!-- Status e Prioridade à direita com largura definida -->
                                    <div
                                        class="flex items-center justify-end gap-2 lg:gap-4 w-auto lg:w-1/4"
                                    >
                                        <Icon
                                            @click="
                                                () => {
                                                    showTask = !showTask;
                                                    activeTaskEdit = task;
                                                }
                                            "
                                            icon="mdi:edit"
                                            class="text-gray-600 cursor-pointer hover:opacity-60"
                                        />

                                        <!-- Status -->
                                        <!-- <div class="flex items-center gap-2">
                                            <span
                                                :class="{
                                                    'text-blue-600':
                                                        task.status === 'done',
                                                    'text-yellow-600':
                                                        task.status ===
                                                        'in_progress',
                                                    'text-purple-600':
                                                        task.status === 'todo',
                                                }"
                                                class="text-sm font-medium flex items-center gap-2"
                                            >
                                                <Icon
                                                    v-if="
                                                        task.status === 'done'
                                                    "
                                                    icon="mdi:check-circle"
                                                    class="w-5 h-5"
                                                />
                                                <Icon
                                                    v-if="
                                                        task.status ===
                                                        'in_progress'
                                                    "
                                                    icon="mdi:progress-clock"
                                                    class="w-5 h-5"
                                                />
                                                <Icon
                                                    v-if="
                                                        task.status === 'todo'
                                                    "
                                                    icon="mdi:clipboard-outline"
                                                    class="w-5 h-5"
                                                />
                                            </span>
                                        </div> -->

                                        <!-- Prioridade -->

                                        <div>
                                            <ElTag
                                                :type="
                                                    task.priority === 'low'
                                                        ? 'info'
                                                        : task.priority ===
                                                            'medium'
                                                          ? 'warning'
                                                          : task.priority ===
                                                              'high'
                                                            ? 'danger'
                                                            : ''
                                                "
                                                style="
                                                    flex-direction: type row;
                                                    display: flex;
                                                "
                                                class="text-center px-1 sm:px-3 py-1 rounded-sm text-[13px] w-16 text-gray-100 flex items-center j"
                                            >
                                                {{
                                                    translatedPriority[
                                                        task.priority
                                                    ]
                                                }}
                                            </ElTag>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer for New Task -->
                <ElDrawer
                    v-model="drawer"
                    title="Nova Tarefa"
                    size="50%"
                    :withHeader="false"
                >
                    <div class="text-center">
                        <ElText>Criar nova Tarefa</ElText>
                    </div>
                    <div class="p-6">
                        <form class="space-y-6">
                            <!-- Título -->
                            <div class="space-y-2">
                                <ElText class="text-gray-700"
                                    >Título da Tarefa</ElText
                                >
                                <ElInput
                                    v-model="create.taskTitle"
                                    placeholder="Digite um título descritivo"
                                    :prefix-icon="
                                        () =>
                                            h(Icon, {
                                                icon: 'mdi:format-title',
                                            })
                                    "
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

                            <!-- Responsável -->
                            <div class="space-y-2">
                                <ElText class="text-gray-700"
                                    >Responsável</ElText
                                >
                                <ElSelect
                                    v-model="create.responsible_id"
                                    placeholder="Selecione um responsável"
                                    class="w-full"
                                >
                                    <ElOption
                                        v-for="user in users"
                                        :key="user"
                                        :value="user.id"
                                        :label="user.name"
                                    />
                                </ElSelect>
                            </div>

                            <!-- Prioridade e Status -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <ElText class="text-gray-700"
                                        >Prioridade</ElText
                                    >
                                    <ElSelect
                                        v-model="create.priority"
                                        class="w-full"
                                    >
                                        <ElOption value="low" label="Baixa">
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:flag-outline"
                                                    class="mr-2 text-green-500"
                                                />
                                                Baixa
                                            </div>
                                        </ElOption>
                                        <ElOption value="medium" label="Média">
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:flag"
                                                    class="mr-2 text-yellow-500"
                                                />
                                                Média
                                            </div>
                                        </ElOption>
                                        <ElOption value="high" label="Alta">
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:flag"
                                                    class="mr-2 text-red-500"
                                                />
                                                Alta
                                            </div>
                                        </ElOption>
                                    </ElSelect>
                                </div>

                                <div class="space-y-2">
                                    <ElText class="text-gray-700"
                                        >Status</ElText
                                    >
                                    <ElSelect
                                        v-model="create.status"
                                        class="w-full"
                                    >
                                        <ElOption value="todo" label="A fazer">
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:clipboard-outline"
                                                    class="mr-2 text-gray-500"
                                                />
                                                A fazer
                                            </div>
                                        </ElOption>
                                        <ElOption
                                            value="in_progress"
                                            label="Em andamento"
                                        >
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:progress-clock"
                                                    class="mr-2 text-yellow-500"
                                                />
                                                Em andamento
                                            </div>
                                        </ElOption>
                                        <ElOption
                                            value="done"
                                            label="Concluído"
                                        >
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:check-circle"
                                                    class="mr-2 text-blue-500"
                                                />
                                                Concluído
                                            </div>
                                        </ElOption>
                                    </ElSelect>
                                </div>

                                <div class="w-full">
                                    <ElText class="text-gray-700"
                                        >Finalidade da Tarefa</ElText
                                    >
                                    <ElSelect
                                        v-model="create.specifically"
                                        class="w-full"
                                    >
                                        <ElOption
                                            value="newResource"
                                            label="Novo Recurso"
                                        >
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:plus-circle-outline"
                                                    class="mr-2 text-green-500"
                                                />
                                                Adicionar um novo recurso
                                            </div>
                                        </ElOption>
                                        <ElOption
                                            value="fixBug"
                                            label="Corrigir um Erro"
                                        >
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:alert-circle-outline"
                                                    class="mr-2 text-yellow-500"
                                                />
                                                Corrigir um erro
                                            </div>
                                        </ElOption>
                                        <ElOption
                                            value="improveExperience"
                                            label="Melhorar a experiência"
                                        >
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:tune"
                                                    class="mr-2 text-red-500"
                                                />
                                                Melhorar a experiência do
                                                usuário
                                            </div>
                                        </ElOption>
                                        <ElOption value="other" label="Outros">
                                            <div class="flex items-center">
                                                <Icon
                                                    icon="mdi:help-circle-outline"
                                                    class="mr-2 text-gray-500"
                                                />
                                                Outros
                                            </div>
                                        </ElOption>
                                    </ElSelect>
                                </div>
                            </div>

                            <!-- Progresso -->
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <ElText class="text-gray-700"
                                        >Progresso</ElText
                                    >
                                    <span class="text-sm text-gray-500"
                                        >{{ create.progress }}%</span
                                    >
                                </div>
                                <ElSlider
                                    v-model="create.progress"
                                    :step="10"
                                    :show-tooltip="false"
                                    show-stops
                                />
                            </div>
                            <div v-if="props.errors.length">
                                {{ errors }}
                            </div>
                            <!-- Botões -->
                            <div class="flex justify-end space-x-4 pt-4">
                                <ElButton @click="drawer = false"
                                    >Cancelar</ElButton
                                >
                                <ElButton
                                    type="primary"
                                    class="flex items-center"
                                    @click="createTask"
                                >
                                    <Icon icon="mdi:check" class="mr-2" />
                                    Criar Tarefa
                                </ElButton>
                            </div>
                        </form>
                    </div>
                </ElDrawer>

                <!-- Drawer for Description and Progress Updates -->
                <ElDrawer
                    v-model="descriptionDrawer"
                    title="Mudança de Descrição"
                    size="50%"
                    :withHeader="false"
                >
                    <div class="p-6 space-y-6">
                        <div
                            class="text-gray-700 font-semibold flex items-center justify-center gap-2"
                        >
                            <p>Mudança de Descrição</p>
                            <Icon
                                icon="mdi:alert-circle-outline"
                                class="text-xl"
                            />
                        </div>

                        <div>
                            <ElText class="text-gray-700 font-semibold"
                                >Sua antiga descrição:</ElText
                            >
                            <p
                                class="border rounded-md p-2 text-gray-600 text-sm mt-1 bg-gray-200"
                            >
                                {{ activeDescriptionForCompare }}
                            </p>
                        </div>

                        <div>
                            <ElText class="text-gray-700 font-semibold"
                                >Sua nova descrição:</ElText
                            >
                            <ElInput
                                v-model="newDescription"
                                type="textarea"
                                :rows="4"
                                placeholder="Descreva os detalhes da tarefa"
                                class="mt-2"
                            />
                        </div>

                        <div class="flex justify-end space-x-4 pt-4">
                            <ElButton @click="descriptionDrawer = false"
                                >Cancelar</ElButton
                            >
                            <ElButton
                                type="primary"
                                class="flex items-center"
                                @click="
                                    updateTask('description', newDescription)
                                "
                            >
                                <Icon icon="mdi:check" class="mr-2" />
                                Atualizar Descrição
                            </ElButton>
                        </div>
                    </div>
                </ElDrawer>

                <ElDrawer
                    v-model="progressDrawer"
                    title="Mudança de Progresso"
                    size="50%"
                    :withHeader="false"
                >
                    <div class="p-6 space-y-6">
                        <div
                            class="text-gray-700 font-semibold flex items-center justify-center gap-2"
                        >
                            <p>Mudança de Progresso</p>
                            <Icon
                                icon="mdi:alert-circle-outline"
                                class="text-xl"
                            />
                        </div>

                        <div>
                            <ElText class="text-gray-700 font-semibold"
                                >Seu novo Progresso:</ElText
                            >
                            <ElSlider
                                v-model="newProgress"
                                :step="10"
                                show-stops
                                :show-tooltip="false"
                            />
                        </div>
                        <ElText
                            >Seu novo Progresso será: {{ newProgress }}%</ElText
                        >

                        <div class="flex justify-end space-x-4 pt-4">
                            <ElButton @click="progressDrawer = false"
                                >Cancelar</ElButton
                            >
                            <ElButton
                                type="primary"
                                class="flex items-center"
                                @click="updateTask('progress', newProgress)"
                            >
                                <Icon icon="mdi:check" class="mr-2" />
                                Atualizar Progresso
                            </ElButton>
                        </div>
                    </div>
                </ElDrawer>
            </div>
        </div>

        <div v-if="showTask" class="mt-16">
            <div
                class="overflow-auto border-r-2 shadow-md flex flex-col h-5/6 bg-white w-[30rem] p-4"
            >
                <div class="flex gap-2 mb-6 ml-2">
                    <div class="flex flex-col gap-6 text-center pt-2">
                        <div class="flex items-center gap-4">
                            <ElDropdown
                                onclick="changeResponsible"
                                placement="bottom-end"
                            >
                                <img
                                    class="rounded-full h-16 w-16 object-cover"
                                    :src="
                                        activeTaskEdit.responsible
                                            .profile_photo_url
                                    "
                                />

                                <template #dropdown>
                                    <div
                                        v-for="user in project.users"
                                        :key="user.id || user"
                                    >
                                        <el-dropdown-item
                                            @click="
                                                updateTask(
                                                    'responsible',
                                                    user.id,
                                                )
                                            "
                                            >{{ user.name }}</el-dropdown-item
                                        >
                                    </div>
                                </template>
                            </ElDropdown>
                            {{ activeTaskEdit.responsible.name }}
                        </div>

                        <div class="flex text-start gap-2 ml-2 flex-col w-full">
                            <div class="flex justify- items-center">
                                <div class="flex gap-4 items-center">
                                    <div class="flex gap-2 items-center">
                                        <ElText>Status</ElText>
                                        <ElTag round>
                                            {{
                                                translatedStatus[
                                                    activeTaskEdit.status
                                                ]
                                            }}
                                        </ElTag>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <ElText>Prioridade</ElText>
                                        <ElTag round>
                                            {{
                                                translatedPriority[
                                                    activeTaskEdit.priority
                                                ]
                                            }}
                                        </ElTag>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p size="large" class="font-semibold px-1 text-gray-600">
                    {{ activeTaskEdit.title }}
                </p>

                <ElText
                    class="rounded-xl p-1"
                    style="margin-top: 6px; margin-bottom: 6px; padding: 4px"
                >
                    {{ activeTaskEdit.description }}</ElText
                >

                <div class="border rounded-xl p-1 mt-[52px]">
                    <p class="border-b p-2">Comentários</p>

                    <div class="w-full h-80 overflow-auto rounded-xl p-2">
                        <div>
                            <div
                                v-for="comment in activeTaskEdit.comments"
                                :key="comment.id"
                                class="p-2"
                            >
                                <div
                                    class="flex flex-col items-start mt-1 p-2 rounded-2xl"
                                >
                                    <div class="flex items-center gap-2">
                                        <img
                                            class="rounded-full h-8 w-8 object-cover"
                                            :src="
                                                comment.responsible
                                                    .profile_photo_url
                                            "
                                        />
                                        {{ comment.responsible.name }}
                                    </div>

                                    <div class="flex flex-col mt-2 gap-2">
                                        <!-- Corrigido para garantir que o conteúdo seja renderizado corretamente -->
                                        <span>{{ comment.content }}</span>
                                        <!-- Se ElText não existir ou não for necessário -->

                                        <div class="flex items-center gap-2">
                                            <ElButton
                                                round
                                                size="small"
                                                @click="liked(comment.id)"
                                            >
                                                <Icon
                                                    icon="mdi:like"
                                                    class="mr-1"
                                                />
                                                {{ comment.likes.length }}
                                            </ElButton>

                                            <!-- Apenas mostra o dropdown se houver likes -->
                                            <ElDropdown
                                                v-if="comment.likes.length"
                                            >
                                                <Icon
                                                    class="cursor-pointer hover:opacity-60 text-[15px]"
                                                    icon="mdi:eye"
                                                />
                                                <template #dropdown>
                                                    <div
                                                        v-for="whoLiked in comment.likes"
                                                        :key="whoLiked.user.id"
                                                    >
                                                        <ElDropdownItem>
                                                            {{
                                                                whoLiked.user
                                                                    .name
                                                            }}
                                                        </ElDropdownItem>
                                                    </div>
                                                </template>
                                            </ElDropdown>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-4">
                        <img
                            :src="$page.props.auth.user.profile_photo_url"
                            class="object-cover h-8 w-8 rounded-full"
                            alt=""
                        />
                        <ElInput
                            v-model="newComment"
                            placeholder="Novo Comentário.."
                            class=" "
                            textarea
                        >
                            <template #append>
                                <Icon
                                    @click="commentTaskF"
                                    icon="mdi:create-outline"
                                    class="cursor-pointer text-lg hover:opacity-60 transition-all"
                                />
                            </template>
                        </ElInput>
                    </div>
                </div>

                <!-- <img
                                :src="
                                    activeTaskEdit.responsible.profile_photo_path
                                "
                                class="rounded-full w-24 h-24  object-cover"
                            />
                            <p>
                                {{ activeTaskEdit.responsible.name }}
                            </p>

                            <ElSlider
                                :show-tooltip="false"
                                :model-value="activeTaskEdit.progress"
                            /> -->
            </div>
        </div>
    </div>
</template>

<script setup>
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
import { Head } from "@inertiajs/vue3";
import { formatDate } from "../utils/formatDate.js";
import { Icon } from "@iconify/vue";
import { h } from "vue";
import { router } from "@inertiajs/vue3";
const props = defineProps([
    "id",
    "project",
    "users",
    "tasks",
    "comments",
    "errors",
]);

import { ref, computed } from "vue";

const drawer = ref(false);
const showTask = ref(false);
const showFullDescription = ref(false);
const shrink = ref(false);
const activeTaskEdit = ref();
const newComment = ref("");

const create = ref({
    taskTitle: "",
    taskDescription: "",
    specifically: "newResource",
    priority: "low",
    responsible_id: undefined,
    status: "todo",
    progress: 0,
});

const translatedProjectType = computed(() => ({
    programming: "Programação",
    design: "Design",
    engineering: "Engenharia",
}));

const truncatedDescription = computed(() => {
    const maxLength = 100;
    if (props.project.description.length > maxLength) {
        return props.project.description.substring(0, maxLength) + "...";
    }
    return props.project.description;
});

const isTruncated = computed(() => {
    return props.project.description.length > 100;
});

import {
    ElButton,
    ElDrawer,
    ElInput,
    ElMessageBox,
    ElOption,
    ElSelect,
    ElText,
    ElProgress,
    ElSlider,
    ElMessage,
    ElDropdown,
    ElDropdownItem,
} from "element-plus";
import axios from "axios";

const translatedPriority = computed(() => ({
    low: "Baixa",
    medium: "Média",
    high: "Alta",
}));

const translatedStatus = computed(() => ({
    done: "Concluído",
    in_progress: "Em andamento",
    todo: "A fazer",
}));

const deleteProjectIfOwner = (id) => {
    ElMessageBox.confirm(
        "Tem certeza que deseja excluir este projeto?",
        "Confirmação",
        {
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            type: "error",
        },
    )
        .then(() => {
            router.delete(route("projects.delete", { id }), {
                onError: () => {
                    ElMessage.error("Ocorreu um erro ao deletar o projeto.");
                },
            });
        })
        .catch(() => {
            // Handle cancel action
        });
};

// n esta atualizando
function commentTaskF() {
    router.post(
        route("comments.createComment"),
        {
            taskId: activeTaskEdit.value.id,
            content: newComment.value,
        },
        {
            onSuccess: () => {
                newComment.value = "";
                activeTaskEdit.value = props.tasks.find(
                    (task) => task.id === activeTaskEdit.value.id,
                );
            },
        },
    );
}

function liked(commentId) {
    router.post(
        route("comments.liked"),
        { commentId: commentId },
        {
            onSuccess: () => {
                activeTaskEdit.value = props.tasks.find(
                    (task) => task.id === activeTaskEdit.value.id,
                );
            },
        },
    );
}

const createTask = () => {
    if (
        (create.value.status === "in_progress" &&
            create.value.progress === 100) ||
        (create.value.status === "todo" && create.value.progress === 100)
    ) {
        return ElMessage.error(
            "O progresso está em 100%, mas você disse que ainda está em andamento.",
        );
    }
    router.post(
        route("projects.createTask"),
        {
            title: create.value.taskTitle,
            description: create.value.taskDescription,
            specifically: create.value.specifically,
            priority: create.value.priority,
            responsible_id: create.value.responsible_id,
            status: create.value.status,
            progress: create.value.progress,
            project_id: props.project.id,
        },
        {
            onSuccess: () => {
                drawer.value = false;
            },
            onError: () => {},
        },
    );

    create.value.taskTitle = "";
    create.value.taskDescription = "";
    create.value.priority = "low";
    create.value.responsible_id = undefined;
    create.value.status = "todo";
    create.value.progress = 0;
};

const deleteTask = (id) => {
    ElMessageBox.confirm(
        "Tem certeza que deseja excluir esta tarefa?",
        "Confirmação",
        {
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            type: "warning",
        },
    )
        .then(() => {
            router.delete(route("projects.deleteTask", { id }), {
                onError: () => {
                    ElMessage.error("Ocorreu um erro ao deletar a tarefa.");
                },
            });
        })
        .catch(() => {
            // Handle cancel action
        });
};

const descriptionDrawer = ref(false);
const activeDescriptionForCompare = ref("");
const currentTaskId = ref(null);
const progressDrawer = ref(false);
const activeProgressForCompare = ref(0);
const newProgress = ref(0);
const newDescription = ref("");

const changeProgress = (progress, taskId) => {
    if (progress === 100) {
        return ElMessage({
            message: "A tarefa já foi concluida.",
            type: "info",
        });
    }
    progressDrawer.value = true;
    activeProgressForCompare.value = progress;
    currentTaskId.value = taskId;
};
function changeDescriptionDrawer(description, taskId) {
    descriptionDrawer.value = true;
    activeDescriptionForCompare.value = description;
    currentTaskId.value = taskId;
}

function updateTask(type, id, value) {
    if (type === "description") {
        if (newDescription.value !== "") {
            try {
                router.put(
                    route("projects.updateTask", {
                        projectId: props.project.id,
                        taskId: currentTaskId.value,
                    }),
                    {
                        description: newDescription.value,
                    },
                );
                newDescription.value = "";
                descriptionDrawer.value = false;
            } catch (error) {
                console.log(error);
            }
        } else {
            ElMessageBox.alert("A descrição não pode ser vazia", "Erro", {
                confirmButtonText: "Ok",
                type: "error",
            });
        }
        descriptionDrawer.value = false;
    }
    if (type === "progress") {
        if (newProgress.value > activeProgressForCompare.value) {
            try {
                router.put(
                    route("projects.updateTask", {
                        projectId: props.project.id,
                        taskId: currentTaskId.value,
                    }),
                    {
                        progress: newProgress.value,
                    },
                );
                newProgress.value = 0;
                progressDrawer.value = false;
            } catch (error) {
                console.log(error);
            }
        } else {
            ElMessageBox.alert(
                "O novo progresso precisa ser maior que o atual.",
                "Erro",
                {
                    confirmButtonText: "Ok",
                    type: "error",
                },
            );
        }
    }

    if (type === "responsible") {
        try {
            router.put(
                route("projects.updateTask", {
                    projectId: props.project.id,
                    taskId: currentTaskId.value,
                }),
                {
                    responsible_id: id,
                },
            );
        } catch (error) {
            console.log(error);
        }
    }
}
</script>

<style>
/* Esconder a bolinha do slider com a classe el-slider__button */
.el-slider__button {
    display: none;
}

@media (max-width: 700px) {
    .sliderStyle {
        width: 70% !important; /* Largura para telas de dispositivos móveis */
    }
}
</style>
