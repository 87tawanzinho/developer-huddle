<template>
    <div class="flex">
      <SidebarLayout />
      <div class="flex justify-center w-full mt-24">
        <div class="flex flex-col items-center bg-gray-50 py-12 px-6 sm:px-8 lg:px-12 rounded-lg shadow-md">
          <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Escolha seu Plano</h1>
          <p class="text-gray-700 text-lg mb-6 text-center">
            Adapte a sua equipe com o plano ideal. Comece a criar projetos hoje mesmo!
          </p>
          <div class="grid gap-8 lg:grid-cols-2">
            <!-- Plano Básico -->
            <div
              class="relative bg-white border border-gray-300 rounded-lg shadow-lg hover:shadow-xl w-96 transition-transform transform hover:scale-105"
            >
              <div class="p-6 text-center">
                <div class="flex justify-center mb-4 text-blue-500">
                  <Icon icon="mdi:account-circle-outline" width="48" height="48" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Plano Básico</h2>
                <p class="text-lg text-blue-600 font-semibold mb-4">R$30/mês</p>
                <ul class="space-y-4 text-gray-700">
                  <li class="flex items-center">
                    <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                    1 administrador
                  </li>
                  <li class="flex items-center">
                    <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                    Até 3 membros de equipe
                  </li>
                  <li class="flex items-center">
                    <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                    Poder criar projetos
                  </li>
                  <li class="flex items-center">
                    <Icon icon="mdi:email-outline" class="text-blue-500 mr-2" width="20" height="20" />
                    Suporte por email
                  </li>
                </ul>
                <button class="mt-6 w-full btn-primary flex items-center justify-center">
                  <Icon icon="mdi:cart-outline" class="mr-2" width="20" height="20" />
                  Assinar Agora
                </button>
              </div>
            </div>
  
            <!-- Plano Premium -->
            <div
              class="relative bg-white border border-blue-400 rounded-lg shadow-lg hover:shadow-xl w-96 transition-transform transform hover:scale-105"
            >
              <div class="p-6 text-center">
                <div class="flex justify-center mb-4 text-yellow-500">
                  <Icon icon="mdi:crown-outline" width="48" height="48" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Plano Premium</h2>
                <p class="text-lg text-blue-600 font-semibold mb-4">R$60/mês</p>
                <ul class="space-y-4 text-gray-700">
                  <li class="flex items-center">
                    <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                    Até 3 administradores
                  </li>
                  <li class="flex items-center">
                    <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                    Até 10 membros de equipe
                  </li>
                  <li class="flex items-center">
                    <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                    Poder criar projetos
                  </li>
                  <li class="flex items-center">
                    <Icon icon="mdi:star-circle-outline" class="text-yellow-500 mr-2" width="20" height="20" />
                    Suporte prioritário
                  </li>
                </ul>
                <button class="mt-6 w-full btn-primary flex items-center justify-center">
                  <Icon icon="mdi:cart-outline" class="mr-2" width="20" height="20" />
                  Assinar Agora
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Icon } from "@iconify/vue";
  import SidebarLayout from "@/Layouts/SidebarLayout.vue";
  
  export default {
    components: { Icon, SidebarLayout },
    name: "Prices",
  };
  </script>
  
  <style>
  .btn-primary {
    @apply bg-gradient-to-r from-blue-500 to-yellow-500 text-white font-semibold py-2 px-4 rounded-md transition hover:from-blue-600 hover:to-yellow-600;
  }
  </style>
  