<script setup>
import { Head, router } from '@inertiajs/vue3';
import { computed, defineProps, h, ref, onMounted } from 'vue';
import { Icon } from '@iconify/vue';
import { useInvitesStore } from '@/stores/useInviteStore';
import {
  ElButton,
  ElDatePicker,
  ElDrawer,
  ElForm,
  ElFormItem,
  ElInput,
  ElMessage,
  ElMessageBox,
  ElText,
  ElUpload
} from 'element-plus';
import axios from 'axios';
import SidebarLayout from '@/Layouts/SidebarLayout.vue';
import Invites from '@/Components/Invites.vue';

const inviteStore = useInvitesStore();

const drawer = ref(false);
const isMobile = ref(false);

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  projects: Array,
  user: Array,
  invitations: Object
});

onMounted(() => {
  inviteStore.invitations = props.invitations
})
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
};

const handleSubmit = async () => {
  if (!form.value.image || form.value.image.length === 0) {
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
  router.post(route('projects.store'), formData);
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
  ElMessageBox.prompt('Pergunte a seu colega o seu username', 'Convite', {
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancelar',
  })
    .then(({ value }) => {
      axios.post(route('invite.send'), {
        username: value,
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

// Detecta o tamanho da tela para ajustar o drawer
onMounted(() => {
  isMobile.value = window.innerWidth <= 640;
});

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
          <Icon icon="mdi:plus" class="text-xl mr-1" />
          Criar Novo Projeto
        </ElButton>
      </div>

      <div class=" flex flex-wrap gap-2">
        <div v-for="project in projectsFiltered" :key="project.id" class=" flex flex-wrap w-96 relative bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 ease-in-out border border-gray-300">
          <img :src="`/storage/${project.cover_path}`" alt="Project Image" class="w-full h-32 sm:h-48 object-cover rounded-t-lg" />
          <div class="p-3 sm:p-4 md:p-6">
            <div class="flex items-center gap-2 mb-2">
              <Icon icon="mdi:account" class="text-gray-500 text-sm sm:text-base" />
              <ElText class="text-sm sm:text-base">{{ project.owner[0]?.name }}</ElText>
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

    <ElDrawer
      v-model="drawer"
      style="background: #f9fafb;"
      title="Criar Novo Projeto"
      :with-header="false"
      :size="isMobile ? '100%' : '40%'"
      :before-close="isClosed"
    >
    <ElForm
    :label-position="'left'"
    label-width="auto"
    style="max-width: 500px"
    class="flex flex-col gap-2  justify-center   items-start   ">
  <ElFormItem label="Título" class="w-full">
    <ElInput v-model="form.title" placeholder="Título do Projeto" class="w-full" />
  </ElFormItem>

  <ElFormItem label="Descrição" class="w-full">
    <ElInput type="textarea" v-model="form.description" placeholder="Descrição do Projeto" class="w-full" />
  </ElFormItem>

  <ElFormItem label="Data de Início" class="w-full">
    <ElDatePicker format="DD/MM/YYYY" value-format="YYYY-MM-DD HH:mm:ss" v-model="form.start_date" type="date" placeholder="Escolha a data de início" class="w-full" />
  </ElFormItem>

  <ElFormItem label="Data Final" class="w-full">
    <ElDatePicker format="DD/MM/YYYY" value-format="YYYY-MM-DD HH:mm:ss" v-model="form.end_date" type="date" placeholder="Escolha a data final" class="w-full" />
  </ElFormItem>

  <ElFormItem label="Imagem" class="w-full">
    <ElUpload action="#" list-type="picture-card" :on-change="handleImageChange" :auto-upload="false">
      <i class="el-icon-plus"></i>
      <img v-if="form.image && form.image.length > 0" :src="form.image[0].url" class="avatar" />
    </ElUpload>
  </ElFormItem>

  <ElFormItem class="w-full flex flex-col sm:flex-row justify-between gap-2">
   <div class="flex items-center">
    <ElButton type="primary" @click="handleSubmit" class="w-full sm:w-auto bg-blue-600 text-white hover:bg-blue-500 transition duration-300" :disabled="!isFormValid">
      Criar Projeto
    </ElButton>
    <ElButton @click="isClosed" class="w-full sm:w-auto bg-gray-400 text-white hover:bg-gray-300 transition duration-300">
      Cancelar
    </ElButton>
   </div>
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