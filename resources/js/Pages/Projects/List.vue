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
import { formatDate, formatDateJustYearAndMonth } from '../utils/formatDate';

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
    <div class="flex-1 py-4">
 
      <div class="flex px-4 sm:px-0 sm:flex-row justify-center items-center gap-4 mb-6">
        <div class="flex items-center gap-2 w-full border-b-2 rounded-lg border-gray-400 focus-within:border-blue-500">
  <svg
    xmlns="http://www.w3.org/2000/svg"
    class="w-6 h-6 text-gray-500 absolute mx-2"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
    stroke-width="2"
  >
    <path
      stroke-linecap="round"
      stroke-linejoin="round"
      d="M10 18a8 8 0 100-16 8 8 0 000 16zm8-2l4 4"
    />
  </svg>
  <input
    v-model="searchQuery"
    type="text"
    class="w-full py-4 outline-none placeholder-gray-500 px-9 rounded-lg"
    placeholder="Escreva para procurar.."
  />
</div>

  <button
    @click="drawer = true"
    title="Add New"
    class="group cursor-pointer outline-none hover:rotate-90 duration-300"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="50px"
      height="50px"
      viewBox="0 0 24 24"
      class="stroke-blue-600 fill-none group-hover:fill-indigo-800 group-active:stroke-indigo-200 group-active:fill-indigo-600 group-active:duration-0 duration-300"
    >
      <path
        d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
        stroke-width="1.5"
      ></path>
      <path d="M8 12H16" stroke-width="1.5"></path>
      <path d="M12 16V8" stroke-width="1.5"></path>
    </svg>
  </button>
</div>


      
      <div class=" flex flex-wrap gap-2">
        <div v-for="project in projectsFiltered" :key="project.id" class="border  w-full flex flex-wrap  sm:w-96 lg:w-[24rem] relative bg-white rounded-lg hover:shadow-lg transition duration-200 ease-in-out ">
          <a :href="route('projects.show', project.id)" class="w-full">
          <img :src="`/storage/${project.cover_path}`" alt="Project Image" class="w-full h-32 sm:h-48 object-cover rounded-t-lg" />
          <div class="p-3 sm:p-4 md:p-6">
            <div class="flex items-center gap-2 mb-2 border-b bg-red-50 w-max text-red-600 px-2 text-sm rounded-lg">
              <Icon icon="mdi:account" class="" />
              <p class=" ">{{ project.owner[0]?.name }}</p>
            </div>
            <h3 class="text-base sm:text-lg md:text-xl font-medium text-gray-800 mb-2 sm:mb-3">{{ project.name }}</h3>
            <p class="text-sm sm:text-base text-gray-600  mb-8 overflow-hidden truncate ">{{ project.description }}</p>
          
            <div class="flex items-center gap-2 p-1 border-b mb-1 ">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="#575757" d="M12 20a7 7 0 0 1-7-7a7 7 0 0 1 7-7a7 7 0 0 1 7 7a7 7 0 0 1-7 7m7.03-12.61l1.42-1.42c-.45-.51-.9-.97-1.41-1.41L17.62 6c-1.55-1.26-3.5-2-5.62-2a9 9 0 0 0-9 9a9 9 0 0 0 9 9c5 0 9-4.03 9-9c0-2.12-.74-4.07-1.97-5.61M11 14h2V8h-2m4-7H9v2h6z"/></svg>
              <ElText>{{ formatDateJustYearAndMonth(project.start_date) }}</ElText>
             </div>
            
            <div class="flex flex-col sm:flex-row gap-2 items-center">
              
             
              <div class="flex items-center justify-between w-full">

              <div v-for="pic in project.users">
                <img :src="pic.profile_photo_url" alt="" class="rounded-full h-8 w-8">
              </div>

              
      
               <svg class="hover:bg-blue-200 rounded-full" @click="(e) => {
                e.preventDefault()
                openSendInvite(project.id)
               }" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#575757" d="M15 4a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4m0 1.9a2.1 2.1 0 1 1 0 4.2A2.1 2.1 0 0 1 12.9 8A2.1 2.1 0 0 1 15 5.9M4 7v3H1v2h3v3h2v-3h3v-2H6V7zm11 6c-2.67 0-8 1.33-8 4v3h16v-3c0-2.67-5.33-4-8-4m0 1.9c2.97 0 6.1 1.46 6.1 2.1v1.1H8.9V17c0-.64 3.1-2.1 6.1-2.1"/></svg>

              </div>


            </div>
            </div>
        
        </a>
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
