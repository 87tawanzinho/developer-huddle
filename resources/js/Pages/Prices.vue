<template>
  <div class="flex flex-col lg:flex-row">
    <SidebarLayout />
    <div class="flex justify-center w-full mt-12 lg:mt-24 px-4">
      <div class="flex flex-col items-center bg-gray-50 py-8 px-4 sm:px-6 lg:px-12 rounded-lg shadow-lg w-full max-w-5xl">
        <h1 class="text-3xl lg:text-5xl font-extrabold text-gray-900 mb-6 lg:mb-10 text-center">
          Escolha seu Plano
        </h1>
        <p class="text-gray-700 text-base lg:text-lg mb-6 lg:mb-8 text-center">
          Adapte a sua equipe com o plano ideal. Comece a criar projetos hoje mesmo!
        </p>
        <div class="grid gap-6 sm:gap-8 lg:grid-cols-3 w-full">

          <!--Plano Free -->
          <!--TODO-->

          <!-- Plano Básico -->
          <div
            class="relative bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition w-full"
          >
            <div class="p-6 text-center">
              <div class="flex justify-center mb-4 text-blue-500">
                <Icon icon="mdi:account-circle-outline" width="48" height="48" />
              </div>
              <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Plano Básico</h2>
              <p class="text-lg text-blue-600 font-semibold mb-4">R$29.99/mês</p>
              <ul class="space-y-3 text-gray-700">
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
            class="relative bg-white border border-blue-400 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition w-full"
          >
            <div class="p-6 text-center">
              <div class="flex justify-center mb-4 text-yellow-500">
                <Icon icon="mdi:crown-outline" width="48" height="48" />
              </div>
              <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Plano Premium</h2>
              <p class="text-lg text-blue-600 font-semibold mb-4">R$59.99/mês</p>
              <ul class="space-y-3 text-gray-700">
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

          <!-- Plano Enterprise -->
          <div
            class="relative bg-white border border-gray-400 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition w-full"
          >
            <div class="p-6 text-center">
              <div class="flex justify-center mb-4 text-purple-500">
                <Icon icon="mdi:rocket-outline" width="48" height="48" />
              </div>
              <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Plano Enterprise</h2>
              <p class="text-lg text-blue-600 font-semibold mb-4">R$99.99/mês</p>
              <ul class="space-y-3 text-gray-700">
                <li class="flex items-center">
                  <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                  Até 10 administradores
                </li>
                <li class="flex items-center">
                  <Icon icon="mdi:check-circle" class="text-green-500 mr-2" width="20" height="20" />
                  Até 50 membros de equipe
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
  @apply bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold py-2 px-4 rounded-md transition hover:from-blue-600 hover:to-purple-600;
}
</style>
