<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, defineProps, computed, h } from 'vue';
import { Icon } from '@iconify/vue';
import { ElButton, ElMessage, ElMessageBox, ElText, ElInput, ElDrawer, ElForm, ElFormItem, ElDatePicker, ElUpload } from 'element-plus';
import axios from 'axios';

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
};

const handleSubmit = async () => {
  const formData = new FormData();
  formData.append('name', form.value.title);
  formData.append('description', form.value.description);
  formData.append('start_date', form.value.start_date);
  formData.append('end_date', form.value.end_date);

  if (form.value.image && form.value.image.length > 0) {
    formData.append('image', form.value.image[0].raw);
  }
  axios.post(route('projects.create'), formData)
    .then(response => {
      Created();
      drawer.value = false;
    })
    .catch(error => {
      console.log(error);
      ErrorWhenCreated();
    });
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
      alert(projectId);
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
 try {
  await axios.post(route('projects.updateInvite'), {
    project_id: projectId,
    token: token
  });

  ElMessage({
    type: 'success',
    message: 'Convite aceito com sucesso.',
  });

  await axios.get(route('home'));
 } catch (error) {
  ElMessage({
    type: 'error',
    message: 'Falha ao aceitar convite.',
  });
   console.log(error);
 }
};

const formatDate = (date) => {
  const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(date).toLocaleDateString('pt-BR', options);
};
</script>

<template>
  <Head title="Welcome" />

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

    <div class="flex-1 p-24">
      <h2 class="text-3xl font-medium text-center text-gray-800 mb-6">Meus Projetos</h2>
      
      <div class="flex justify-center items-center gap-4 mb-6">
        <ElInput
          v-model="searchQuery"
          placeholder="Procurar por Projetos"
          class=""
          :prefix-icon="() => h(Icon, { icon: 'mdi:magnify', class: 'text-gray-500 ' })"
          />
        <ElButton
          type="primary"
          @click="drawer=true"
          class="bg-blue-600 text-white font-medium rounded-lg  hover:bg-blue-500 transition duration-300"
        >
        <Icon icon="mdi:plus" class="text-xl mr-1"/>
          Criar Novo Projeto
        </ElButton>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="project in projectsFiltered" :key="project.id" class="relative bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 ease-in-out border border-gray-300">
          <img :src="`/storage/${project.image}`" alt="Project Image" class="w-full h-48 object-cover rounded-t-lg" />
          <div class="p-6">
             <div class="flex items-center gap-2 mb-2">
              <Icon icon="mdi:account" class="text-gray-500" />
              <ElText>
              
              {{ project.owner }}
            </ElText>
             </div>
            <h3 class="text-xl font-medium text-gray-800 mb-3">{{ project.name }}</h3>
            <p class="text-gray-600 mb-6 h-24 overflow-hidden">{{ project.description }}</p>
            <div class="flex gap-2">
              <a :href="route('projects.show', project.id)">
                <ElButton
                  size="medium"
                  type="primary"
                  class="bg-blue-600 text-white font-medium rounded-lg p-2 hover:bg-blue-500 transition duration-300"
                >
                  Ver Projeto
                </ElButton>
              </a>
              <ElButton
                size="medium"
                @click="openSendInvite(project.id)"
                class="bg-green-600 text-white font-medium rounded-lg p-2 hover:bg-green-500 transition duration-300"
              >
                Enviar Convite
              </ElButton>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-auto bg-white text-gray-900 p-6 shadow-lg border-l border-gray-200 rounded-lg">
    <span v-if="!props.invitations.length" class="text-gray-500 text-sm">Você ainda não possui convites para projetos</span>
    
    <div v-else class="flex flex-col gap-6">
      <div v-for="invitation in props.invitations" :key="invitation.id" class="border border-gray-300 rounded-lg p-4 bg-white text-left shadow-lg hover:shadow-xl transition-shadow duration-300">
        <ElText class="text-lg font-semibold text-gray-800 mb-2">Você foi convidado(a) para um projeto.</ElText>
        
       <div class="flex items-center gap-2 text-gray-600">
        <Icon icon="mdi:account" />
        <p class="text-gray-700 font-medium">{{ invitation.project_name }}</p>
       </div>
       <div class="flex items-center gap-2 text-gray-600">
        <Icon icon="mdi:desktop-mac-dashboard" />
        <p class="text-gray-700 font-medium">{{ invitation.project_description }}</p>
       </div>
        <!-- Exibição das datas -->
        <div class="text-gray-500 text-sm mt-4">
          <p><strong>Início:</strong> {{ formatDate(invitation.start_date) }}</p>
          <p><strong>Fim:</strong> {{ formatDate(invitation.end_date) }}</p>
        </div>

        <!-- Botões de ação com ícones -->
        <div class="flex items-center justify-end gap-4 mt-4">
          <ElButton
            type="success"
            class="bg-green-500 text-white rounded-lg px-4 py-2 hover:bg-green-400 transition duration-300"
            @click="acceptedInvitation(invitation.project_id, invitation.token)"
          >
            <Icon icon="mdi:check-circle" class="mr-2" />
            Aceitar
          </ElButton>
          
          <ElButton
            type="danger"
            class="bg-red-500 text-white rounded-lg px-4 py-2 hover:bg-red-400 transition duration-300"
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
    >
      <ElForm :model="form" label-width="120px">
        <ElFormItem label="Título">
          <ElInput v-model="form.title" placeholder="Título do Projeto" class="border-gray-300" />
        </ElFormItem>
        <ElFormItem label="Descrição">
          <ElInput type="textarea" v-model="form.description" placeholder="Descrição do Projeto" class="border-gray-300" />
        </ElFormItem>
        <ElFormItem label="Data de Início">
          <ElDatePicker v-model="form.start_date" type="date" placeholder="Escolha a data de início" />
        </ElFormItem>
        <ElFormItem label="Data Final">
          <ElDatePicker v-model="form.end_date" type="date" placeholder="Escolha a data final" />
        </ElFormItem>
        <ElFormItem label="Imagem">
          <ElUpload
            action="#"
            list-type="picture-card"
            :file-list="form.image"
            :on-change="handleImageChange"
            :auto-upload="false"
          >
            <i class="el-icon-plus"></i>
            <img v-if="form.image && form.image.length > 0" :src="form.image[0].url" class="avatar" />
          </ElUpload>
        </ElFormItem>
        <ElFormItem class="flex justify-between">
          <ElButton type="primary" @click="handleSubmit" class="bg-blue-600 text-white hover:bg-blue-500 transition duration-300">Criar Projeto</ElButton>
          <ElButton @click="isClosed" class="bg-gray-400 text-white hover:bg-gray-300 transition duration-300">Cancelar</ElButton>
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
    transform: scale(1.05);
  }

  .avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
  }
</style>
