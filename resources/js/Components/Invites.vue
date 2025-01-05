<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { formatDate } from '@/Pages/utils/formatDate';
import { useInvitesStore } from '@/stores/useInviteStore';

const props = defineProps('invitations')

const inviteStore = useInvitesStore();
const drawerSize = ref('100%');  // Tamanho inicial para mobile (100%)

const updateDrawerSize = () => {
  if (window.innerWidth <= 768) {
    drawerSize.value = '100%';  // Mobile
  } else {
    drawerSize.value = '20%';   // Desktop
  }
};

onMounted(() => {
  updateDrawerSize(); // Inicializa o tamanho quando o componente é montado
  window.addEventListener('resize', updateDrawerSize); // Atualiza o tamanho ao redimensionar a janela
});

onUnmounted(() => {
  window.removeEventListener('resize', updateDrawerSize); // Remove o listener quando o componente for destruído
});
</script>

<template>
  <ElDrawer
    v-model="inviteStore.isOpen"
    :size="drawerSize"
    title="Convites Pendentes"
    :visible="inviteStore.isOpen"
    @close="inviteStore.isOpen = false"
  >

    <!-- Mensagem quando não há convites -->
    <div v-if="!invitations?.length" class="flex text-sm flex-col items-center justify-center mt-8 p-8 bg-gray-50 rounded-lg shadow-inner">
      <Icon icon="mdi:email-outline" class="text-gray-400 text-4xl mb-4"/>
      <span class="text-gray-500 text-center">Você não possui convites para projetos no momento</span>
    </div>

    <!-- Lista de convites -->
    <div v-else>
      <div v-for="invitation in invitations" :key="invitation.id" class="bg-gray-50 p-6 rounded-lg shadow-md mb-6 transition-all duration-200 hover:shadow-xl">
        <div class="flex items-center gap-3 mb-4">
          <Icon icon="mdi:account" class="text-gray-500 text-2xl"/>
          <p class="text-gray-700 font-semibold text-lg md:text-xl">{{ invitation.project.name }}</p>
        </div>

        <div class="flex items-center gap-3 text-gray-600 mb-4">
          <p class="text-gray-700 font-medium text-sm md:text-base">{{ invitation.project.description }}</p>
        </div>

        <div class="text-gray-500 text-sm md:text-base mb-6">
          <p><strong>Início:</strong> {{ formatDate(invitation.project.start_date) }}</p>
          <p><strong>Fim:</strong> {{ formatDate(invitation.project.end_date) }}</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-4">
          <ElButton
            type="success"
            class="w-full sm:w-auto bg-green-500 text-white rounded-lg px-4 py-2 md:px-5 md:py-3 hover:bg-green-400 transition duration-300 shadow-md hover:shadow-lg"
            @click="acceptedInvitation(invitation.id)"
          >
            <Icon icon="mdi:check-circle" class="mr-2"/>
            Aceitar
          </ElButton>

          <ElButton
            type="danger"
            class="w-full sm:w-auto bg-red-500 text-white rounded-lg px-4 py-2 md:px-5 md:py-3 hover:bg-red-400 transition duration-300 shadow-md hover:shadow-lg"
          >
            <Icon icon="mdi:cancel" class="mr-2"/>
            Recusar
          </ElButton>
        </div>
      </div>
    </div>
  </ElDrawer>
</template>

