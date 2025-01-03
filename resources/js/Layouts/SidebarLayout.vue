<template>
  <div class="flex min-h-screen bg-gray-50 text-gray-900">
      <!-- Sidebar -->
      <div 
          v-if="$page.props.auth.user" 
          class="w-64 bg-white shadow-lg p-6 flex flex-col items-center gap-8"
      >
          <!-- Logo/Icon -->
          <div class="flex flex-col items-center gap-2">
              <Icon icon="openmoji:cat" class="text-6xl text-blue-600" />
              <span class="text-xl text-center font-semibold text-gray-800 tracking-wide">
                  Reunião dos Devs (Versão Beta)
              </span>
          </div>

          <!-- Navigation Links -->
          <nav class="flex flex-col w-full gap-4">
              <Link 
                  :href="route('home')" 
                  class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
              >
                  <Icon icon="mdi:home" class="text-2xl text-blue-500" />
                  <span>Início</span>
              </Link>
              <Link 
                  :href="route('dashboard')" 
                  class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
              >
                  <Icon icon="mdi:account-circle" class="text-2xl text-blue-500" />
                  <span>Perfil</span>
              </Link>

              <Link 
                  :href="route('prices')" 
                  class="flex items-center gap-3 p-3 w-full text-lg font-medium text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition"
              >
                  <Icon icon="mdi:currency-usd" class="text-2xl text-blue-500" />
                  <span>Planos</span>
              </Link>
          </nav>
      </div>

      <!-- Main Content -->
      <slot />
  </div>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
</script>
