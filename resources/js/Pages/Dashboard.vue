<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Logo from "@/Components/Logo.vue";
</script>

<template>
    <AuthenticatedLayout>
       <div class="is-flex is-flex-direction-column is-centered is-vcentered is-align-content-center is-align-items-center">
           <Logo width="400px" height="300px" />
           <h1 class="is-size-1">Welcome to CASI</h1>
           <h1 class="is-size-2">Peer review system</h1>
       </div>
    </AuthenticatedLayout>
</template>
