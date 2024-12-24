<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import {ref, defineProps, computed} from 'vue';
import { Icon } from '@iconify/vue';
import { ElButton, ElMessage, ElMessageBox, ElText } from 'element-plus';
import axios from 'axios';
const drawer = ref(false)

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    projects: Array,
    user: Array,
    invitations: Object
});

const searchQuery = ref('')
const fileList = ref([])
const form = ref({
    title: '',
    description: '',
    start_date: '',
    end_date: '',
    image: []
})
const projectsFiltered = computed(() => {
     if(searchQuery.value.length > 0) {
        return props.projects.filter(project => 
         project.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
         project.description.toLowerCase().includes(searchQuery.value.toLowerCase())
);
     } else {
        return props.projects
     }
})

const handleImageChange = (file, fileList) => {
    form.value.image = fileList;  // Update the form image list with the selected file
}

 
const handleSubmit = async () => {
    const formData = new FormData()
    formData.append('name', form.value.title)
    formData.append('description', form.value.description)
    formData.append('start_date', form.value.start_date)
    formData.append('end_date', form.value.end_date)
 
    if (form.value.image && form.value.image.length > 0) {
        formData.append('image', form.value.image[0].raw); // Add the raw file object to FormData
    }
    axios.post(route('projects.create'), formData)
    .then(response => {
        this.$router.go();  
        Created()
        drawer.value = false
        
    })
    .catch(error => {
        console.log(error)
        ErrorWhenCreated()
    })
}

const isClosed = () => {
    drawer.value = false
    ElMessage({
        message: 'Operação cancelada.',
        type: 'info',
    })
}

const Created = () => {
  ElMessage({
    message: 'Parabéns, você criou um novo projeto.',
    type: 'success',
  })
}
 
const ErrorWhenCreated = () => {
  ElMessage({
    message: 'Ocorreu um erro.',
    type: 'error',
  })
}

 
const openSendInvite = (projectId) => {
  ElMessageBox.prompt('Pergunte a seu colega o e-mail da conta', 'Convite', {
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancelar',
    inputPattern:
      /[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/,
    inputErrorMessage: 'Email inválido. Tente novamente.',
  })
    .then(({ value }) => {
        alert(projectId)
      // Envia o convite ao backend
      axios.post(route('invite.send'), {
        email: value,
        project_id: projectId, // ID do projeto relacionado
      }, {
        onSuccess: () => {
          ElMessage({
            type: 'success',
            message: `Convite enviado para: ${value}`,
          });
        },
        onError: (errors) => {
          ElMessage({
            type: 'error',
            message: errors.email || 'Falha ao enviar convite.',
          });
        },
      });
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Convite cancelado.',
      });
    });
};


const acceptedInvitation = (projectId, token) => {

      axios.post(route('projects.updateInvite'), {
        project_id: projectId, // ID do projeto relacionado
        token: token
      })
}
</script>

<template>
    <Head title="Welcome" />

    <div class="flex ">
        <div v-if="canLogin" class="p-4 border-r flex flex-col gap-1  bg-slate-900 text-white  h-screen">
            <Link v-if="$page.props.auth.user" :href="route('home')" class="border-b  border-blue-400 hover:text-yellow-200">Início</Link>
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="hover:text-yellow-200">Perfil</Link>
            <template v-else>
            <Link :href="route('login')" class="font-semibold hover:text-blue-600">Log in</Link>

            <Link v-if="canRegister" :href="route('register')" class="hover:text-blue-600">Register</Link>
            </template>
        </div>

       <div class="mt-4 mx-4 flex-1">
            <h2 class="text-3xl font-bold text-center text-gray-800 mt-4">Meus Projetos</h2>
            <div class="flex justify-center items-center py-4 gap-4">
                <ElInput type="text" v-model="searchQuery" placeholder="Procurar por Projetos" class=" p-4 w-full sm:w-80 rounded-lg hover:shadow-md" />
                <Icon icon="flat-color-icons:plus" @click="drawer=true" class="text-[2rem] hover:text-blue-600 cursor-pointer transition-colors duration-300"/>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 py-8 ">
                <div v-for="project in projectsFiltered" :key="project.id" class=" relative bg-white shadow-lg  py-4 rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img :src="`/storage/${project.image}`" alt="Project Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">{{ project.name }}</h3>
                        <p class="text-gray-700 mb-8 h-24 overflow-hidden ">{{ project.description }}</p>
                       <div class="flex absolute bottom-2 items-center gap-2 ">
                       <a :href="route('projects.show', project.id)">
                        <ElButton size="large" type="primary"  class="font-bold bg-yellow-200 text-black rounded-lg  p-2 hover:underline  ">Ver Projeto</ElButton>
                       </a>
                        <ElButton size="large" @click="openSendInvite(project.id)" class="font-bold bg-blue-200 text-black rounded-lg  p-2 hover:underline  ">Enviar um Convite</ElButton>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=" w-72 flex overflow-auto  bg-slate-900  flex-col text-center text-yellow-200  pt-8">
            <span v-if="!invitations.length">Você ainda não possui convites para projetos</span>
            <span v-else class="px-4 py-2 flex flex-col gap-4   ">
              <div v-for="invitation in invitations" :key="invitation.id" class="border border-gray-300 rounded-lg p-4 bg-white text-left">
              <p class="text-lg font-semibold text-gray-800">Você foi convidado(a) para um projeto.</p>
              <div class="flex items-center justify-end mt-2 gap-2">
                <ElButton type="success" class="bg-green-500 text-white rounded-lg px-3 py-1 hover:bg-green-600" @click="acceptedInvitation(invitation.project_id, invitation.token)">Aceitar</ElButton>
                <ElButton type="danger" class="bg-red-500 text-white rounded-lg px-3 py-1 hover:bg-red-600">Recusar</ElButton>
              </div>
              </div>
            </span>
        </div>

        <el-drawer v-model="drawer" style="background: #f4f4f4;" title="Criar Novo Projeto" :with-header="false">
            <el-form :model="form" label-width="120px">
                <el-form-item label="Título">
                    <el-input v-model="form.title"></el-input>
                </el-form-item>
                <el-form-item label="Descrição">
                    <el-input type="textarea" v-model="form.description"></el-input>
                </el-form-item>
                <el-form-item label="Data de Início">
                    <el-date-picker v-model="form.start_date" type="date" placeholder="Escolha a data de início"></el-date-picker>
                </el-form-item>
                <el-form-item label="Data Final">
                    <el-date-picker v-model="form.end_date" type="date" placeholder="Escolha a data final"></el-date-picker>
                </el-form-item>
                <el-form-item label="Imagem">
                    <el-upload  
                        action="#"
                        list-type="picture-card"
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :file-list="form.image"
                        :auto-upload="false"
                        :on-change="handleImageChange">
                        <i class="el-icon-plus"></i>
                        <img v-if="form.image && form.image.length > 0" :src="form.image[0].url" class="avatar" />
                    </el-upload>
                </el-form-item>

                <el-form-item class="flex justify-between">
                    <el-button type="primary" @click="handleSubmit">Criar Projeto</el-button>
                    <el-button @click="isClosed">Cancelar</el-button>
                </el-form-item>
            </el-form>
        </el-drawer>
        


    </div>
</template>

<style scoped>
    .project-card {
        transition: transform 0.3s ease-in-out;
    }
    .project-card:hover {
        transform: scale(1.05);
    }
</style>
