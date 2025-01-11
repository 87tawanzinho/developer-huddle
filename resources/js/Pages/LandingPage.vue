<template>
    <div>
      <Head title="Reunião dos Devs" />
      <div id="topbar" class="p-4 border-b fixed top-0 w-full bg-white z-10">
        <div class="container mx-auto flex justify-between items-center">
          <div class="flex items-center gap-2">
            <Icon icon="mdi:account-group" class="text-4xl text-blue-600" />
            <p variant="body1" class="text-lg font-semibold text-gray-900 tracking-wide">
              Developer Huddle
            </p>
          </div>
          <Link :href="route('login')" v-if="!$page.props.auth.user">
            <ElButton  style="width: 120px; border-radius: 12px;">Login</ElButton>
          </Link>

          <Link :href="route('profile.show')" v-else>
             <div class="flex items-center gap-2">
              <p class="text-sm text-gray-600 hidden lg:flex" >{{ $page.props.auth.user.name }}</p>
              <img :src="$page.props.auth.user.profile_photo_url" alt="User Avatar" class="w-10 h-10 rounded-full" />
            </div>
            </Link>
          </div>
      </div>
  
      <div class="items-center flex flex-col h-full lg:h-screen py-8 lg:py-0 mt-24 lg:mt-32">
        <p variant="h1" class="text-4xl font-extrabold text-gray-800 mb-4 sm:text-4xl text-center">
          Reunião dos Devs
        </p>
        <p variant="body1" class="text-md text-gray-600 mb-6 sm:text-xl w-full text-center">
          Alcance o topo da produtividade. Organize suas tarefas, colabore com sua equipe e maximize seus resultados de forma eficiente e intuitiva.
        </p>
        <div class="flex gap-2 mb-4">
          <Link :href="route('register')">
            <ElButton type="success" size="large" style="width: 140px; border-radius: 12px;">Começar</ElButton>
          </Link>
         <Link :href="route('about')">
          <ElButton type="info" plain size="large" style="width: 140px; border-radius: 12px;">Saber Mais</ElButton>
          </Link>
        </div>
        <img src="/landing_page/teste.jpg" alt="Landing Page" class="rounded-lg shadow-xl w-full sm:w-auto" style="height: auto; max-height: 600px;" />
      </div>
  
      <div class="bg-white py-12 lg:pb-12 lg:py-0">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Nossos Recursos</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex flex-col items-center text-center bg-gray-100 p-6 rounded-lg shadow-lg">
              <Icon icon="mdi:lightbulb-on-outline" class="text-6xl text-blue-600 mb-4" />
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Inovação Contínua</h3>
              <p class="text-gray-600">Estamos sempre atualizando nossas ferramentas para oferecer as soluções mais modernas e eficientes.</p>
            </div>
            <div class="flex flex-col items-center text-center bg-gray-100 p-6 rounded-lg shadow-lg">
              <Icon icon="mdi:account-multiple-outline" class="text-6xl text-blue-600 mb-4" />
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Colaboração Eficiente</h3>
              <p class="text-gray-600">Facilitamos o trabalho em equipe com ferramentas que promovem a comunicação e a produtividade.</p>
            </div>
            <div class="flex flex-col items-center text-center bg-gray-100 p-6 rounded-lg shadow-lg">
              <Icon icon="mdi:chart-line" class="text-6xl text-blue-600 mb-4" />
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Resultados Mensuráveis</h3>
              <p class="text-gray-600">Oferecemos métricas claras para que você possa acompanhar o progresso e o sucesso de sua equipe.</p>
            </div>
          </div>
        </div>
      </div>
  
      <div class="bg-gray-50">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Por que Escolher Nosso Produto?</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col items-center text-center bg-white p-6 rounded-lg shadow-lg">
              <Icon icon="mdi:currency-usd-circle-outline" class="text-6xl text-green-600 mb-4" />
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Preço Muito Mais Baixo que Concorrentes</h3>
              <p class="text-gray-600">Oferecemos soluções de alta qualidade a preços acessíveis, permitindo que você economize significativamente em comparação com outras opções do mercado.</p>
            </div>
            <div class="flex flex-col items-center text-center bg-white p-6 rounded-lg shadow-lg">
              <Icon icon="mdi:headset" class="text-6xl text-blue-600 mb-4" />
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Suporte ao Cliente Diferenciado</h3>
              <p class="text-gray-600">Nossa equipe de suporte está disponível 24/7 para atender suas necessidades, garantindo uma experiência tranquila e eficiente.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
    import { Icon } from '@iconify/vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { ElButton } from 'element-plus';
  </script>
  
  <style>
  </style>
  