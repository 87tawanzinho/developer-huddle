<template>
    <div class="h-full w-full">
        <div class="flex w-full">
            <SidebarLayout />
            <div class="flex mt-8 justify-center w-full gap-2">
                <div
                    class="flex gap-2 flex-col border rounded-2xl h-24 p-2 mx-4 w-full"
                >
                    <h2>Primeira noticia</h2>
                    descricao
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import SidebarLayout from "@/Layouts/SidebarLayout.vue";
</script>
