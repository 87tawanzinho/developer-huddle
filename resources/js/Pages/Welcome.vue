<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, defineProps, computed, h } from 'vue';
import { Icon } from '@iconify/vue';
import { ElButton, ElMessage, ElMessageBox, ElText, ElInput, ElDrawer, ElForm, ElFormItem, ElDatePicker, ElUpload } from 'element-plus';
import axios from 'axios';
import SidebarLayout from '@/Layouts/SidebarLayout.vue';
import { formatDate } from './utils/formatDate';
import { router } from '@inertiajs/vue3'


const drawer = ref(false);

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  projects: Array,
  user: Array,
  invitations: Object
});

const searchQuery = ref('');
const form = ref({
  title: '',
  description: '',
  start_date: '',
  end_date: '',
  image: []
});

const isFormValid = computed(() => {
  return form.value.title && form.value.description && form.value.start_date && form.value.end_date;
});

const projectsFiltered = computed(() => {
  if (searchQuery.value.length > 0) {
    return props.projects.filter(project =>
      project.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      project.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  } else {
    return props.projects;
  }
});

const handleImageChange = (file, fileList) => {
  form.value.image = fileList;
  console.log(fileList)
};

const handleSubmit = async () => {

  if(!form.value.image || form.value.image.length === 0) {
    ElMessage({
      message: 'Por favor, adicione uma imagem para o projeto.',
      type: 'error',
    });
    return;
  }

  
  const formData = new FormData();
  formData.append('name', form.value.title);
  formData.append('description', form.value.description);
  formData.append('start_date', form.value.start_date);
  formData.append('end_date', form.value.end_date);

  if (form.value.image && form.value.image.length > 0) {
    formData.append('image', form.value.image[0].raw);
  }
  router.post(route('projects.create'), formData)
      drawer.value = false;
};

const isClosed = () => {
  drawer.value = false;
  ElMessage({
    message: 'Operação cancelada.',
    type: 'info',
  });
};

const Created = () => {
  ElMessage({
    message: 'Parabéns, você criou um novo projeto.',
    type: 'success',
  });
};

const ErrorWhenCreated = () => {
  ElMessage({
    message: 'Ocorreu um erro.',
    type: 'error',
  });
};

const openSendInvite = (projectId) => {
  ElMessageBox.prompt('Pergunte a seu colega o e-mail da conta', 'Convite', {
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancelar',
    inputPattern:
      /[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/,
    inputErrorMessage: 'Email inválido. Tente novamente.',
  })
    .then(({ value }) => {
      axios.post(route('invite.send'), {
        email: value,
        project_id: projectId,
      })
        .then(() => {
          ElMessage({
            type: 'success',
            message: `Convite enviado para: ${value}`,
          });
        })
        .catch(() => {
          ElMessage({
            type: 'error',
            message: 'Falha ao enviar convite.',
          });
        });
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Convite cancelado.',
      });
    });
};

const acceptedInvitation = async (projectId, token) => {
 router.post(route('projects.updateInvite'), {
    project_id: projectId,
    token: token
  })
  ElMessage({
    type: 'success',
    message: 'Convite aceito com sucesso.',
  });
};

 
</script>

<template>
  <Head title="Welcome" />

  <div class="flex flex-col lg:flex-row min-h-screen">
    <SidebarLayout />
    <div class="flex-1 p-4 md:p-8 lg:p-12">
      <h2 class="text-2xl md:text-3xl font-medium text-center text-gray-800 mb-4 md:mb-6">Meus Projetos</h2>
      
      <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-6">
        <ElInput
          v-model="searchQuery"
          placeholder="Procurar por Projetos"
          class="w-full sm:w-auto"
          :prefix-icon="() => h(Icon, { icon: 'mdi:magnify', class: 'text-gray-500' })"
        />
        <ElButton
          type="primary"
          @click="drawer=true"
          class="w-full sm:w-auto bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-500 transition duration-300"
        >
          <Icon icon="mdi:plus" class="text-xl mr-1"/>
          Criar Novo Projeto
        </ElButton>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6 px-4 sm:px-0">
        <div v-for="project in projectsFiltered" :key="project.id" class="relative bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 ease-in-out border border-gray-300">
          <img :src="`/storage/${project.image}`" alt="Project Image" class="w-full h-32 sm:h-48 object-cover rounded-t-lg" />
          <div class="p-3 sm:p-4 md:p-6">
        <div class="flex items-center gap-2 mb-2">
          <Icon icon="mdi:account" class="text-gray-500 text-sm sm:text-base" />
          <ElText class="text-sm sm:text-base">{{ project.owner }}</ElText>
        </div>
        <h3 class="text-base sm:text-lg md:text-xl font-medium text-gray-800 mb-2 sm:mb-3">{{ project.name }}</h3>
        <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 md:mb-6 h-16 sm:h-20 md:h-24 overflow-hidden">{{ project.description }}</p>
        <div class="flex flex-col sm:flex-row gap-2">
          <a :href="route('projects.show', project.id)" class="w-full">
            <ElButton
          size=""
          type="primary"
          class="w-full bg-blue-600 text-white font-medium rounded-lg p-1.5 sm:p-2 text-sm sm:text-base hover:bg-blue-500 transition duration-300"
            >
          Ver Projeto
            </ElButton>
          </a>
          <ElButton
            size=""
            @click="openSendInvite(project.id)"
            class="w-full bg-green-600 text-white font-medium rounded-lg p-1.5 sm:p-2 text-sm sm:text-base hover:bg-green-500 transition duration-300"
          >
            Enviar Convite
          </ElButton>
        </div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full sm:w-4/5 md:w-[20%] bg-white p-6 md:p-8 shadow-lg rounded-xl border border-gray-200 hover:shadow-2xl transition-all duration-300">
  <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Convites Pendentes</h3>

  <!-- Mensagem quando não há convites -->
  <div v-if="!props.invitations.length" class="flex text-sm flex-col items-center justify-center mt-8 p-8 bg-gray-50 rounded-lg shadow-inner">
    <Icon icon="mdi:email-outline" class=" text-gray-400  text-4xl mb-4" />
    <span class="text-gray-500 text-center ">Você não possui convites para projetos no momento</span>
  </div>

  <!-- Lista de convites -->
  <div v-else>
    <div v-for="invitation in props.invitations" :key="invitation.id" class="bg-gray-50 p-6 rounded-lg shadow-md mb-6 transition-all duration-200 hover:shadow-xl">
      <div class="flex items-center gap-3 mb-4">
        <Icon icon="mdi:account" class="text-gray-500 text-2xl" />
        <p class="text-gray-700 font-semibold text-lg md:text-xl">{{ invitation.project_name }}</p>
      </div>

      <div class="flex items-center gap-3 text-gray-600 mb-4">
        <p class="text-gray-700 font-medium text-sm md:text-base">{{ invitation.project_description }}</p>
      </div>

      <div class="text-gray-500 text-sm md:text-base mb-6">
        <p><strong>Início:</strong> {{ formatDate(invitation.start_date) }}</p>
        <p><strong>Fim:</strong> {{ formatDate(invitation.end_date) }}</p>
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-end gap-4">
        <ElButton
          type="success"
          class="w-full sm:w-auto bg-green-500 text-white rounded-lg px-4 py-2 md:px-5 md:py-3 hover:bg-green-400 transition duration-300 shadow-md hover:shadow-lg"
          @click="acceptedInvitation(invitation.project_id, invitation.token)"
        >
          <Icon icon="mdi:check-circle" class="mr-2" />
          Aceitar
        </ElButton>

        <ElButton
          type="danger"
          class="w-full sm:w-auto bg-red-500 text-white rounded-lg px-4 py-2 md:px-5 md:py-3 hover:bg-red-400 transition duration-300 shadow-md hover:shadow-lg"
        >
          <Icon icon="mdi:cancel" class="mr-2" />
          Recusar
        </ElButton>
      </div>
    </div>
  </div>
</div>


    <ElDrawer
      v-model="drawer"
      style="background: #f9fafb;"
      title="Criar Novo Projeto"
      :with-header="false"
      size="40%"
      :before-close="isClosed"
    >
      <ElForm :model="form" label-width="120px" class="p-4">
        <ElFormItem label="Título">
          <ElInput v-model="form.title" placeholder="Título do Projeto" class="w-full" />
        </ElFormItem>
        <ElFormItem label="Descrição">
          <ElInput type="textarea" v-model="form.description" placeholder="Descrição do Projeto" class="w-full" />
        </ElFormItem>
        <ElFormItem label="Data de Início">
          <ElDatePicker v-model="form.start_date" type="date" placeholder="Escolha a data de início" class="w-full" />
        </ElFormItem>
        <ElFormItem label="Data Final">
          <ElDatePicker v-model="form.end_date" type="date" placeholder="Escolha a data final" class="w-full" />
        </ElFormItem>
        <ElFormItem label="Imagem">
          <ElUpload
            action="#"
            list-type="picture-card"
 
            :on-change="handleImageChange"
            :auto-upload="false"
          >
            <i class="el-icon-plus"></i>
            <img v-if="form.image && form.image.length > 0" :src="form.image[0].url" class="avatar" />
          </ElUpload>
        </ElFormItem>
        <ElFormItem class="flex flex-col sm:flex-row justify-between gap-2">
          <ElButton type="primary" @click="handleSubmit" class="w-full sm:w-auto bg-blue-600 text-white hover:bg-blue-500 transition duration-300" :disabled="!isFormValid">Criar Projeto</ElButton>
          <ElButton @click="isClosed" class="w-full sm:w-auto bg-gray-400 text-white hover:bg-gray-300 transition duration-300">Cancelar</ElButton>
        </ElFormItem>
      </ElForm>
    </ElDrawer>
  </div>
</template>

<style scoped>
  .project-card {
    transition: transform 0.3s ease-in-out;
  }

  .project-card:hover {
    transform: scale(1.02);
  }

  .avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
  }

  @media (max-width: 640px) {
    .project-card:hover {
      transform: none;
    }
  }
</style>
