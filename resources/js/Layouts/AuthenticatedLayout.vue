<script setup>
import SideBar from "@/Components/SideBar.vue";
import Navbar from "@/Components/Navbar.vue";
import flasher from "@flasher/flasher";
import {watch} from "vue";
import {usePage} from "@inertiajs/vue3";

defineProps({
    messages: {
        type: Object,
        default: () => ({})
    },
});

// Watch for changes on messages to display popups
watch(
    () => usePage().props.messages,
    (newValue) => {
        if (newValue) {
            flasher.render(newValue);
        }
    },
    {immediate: true}
);

</script>

<template>
    <div>
        <div class="min-h-screen has-background-light">
            <!-- Nav bar -->
            <Navbar/>
            <!-- Page Content -->
            <main class="columns">
                <SideBar class="column is-one-fifth"/>
                <div class="container column box bg-white m-6 is-overflow-auto p-5">
                    <slot/>
                </div>
            </main>
        </div>
    </div>
</template>
