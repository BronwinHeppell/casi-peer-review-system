<script setup>
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const user = usePage().props.auth.user;

const isActive = (routePath) => {
    return computed(() => usePage().url === routePath || usePage().url.startsWith(routePath));
};

</script>

<template>
    <div class="hero is-fullheight-with-navbar ">
        <aside class="menu block p-3">
            <p class="menu-label">General</p>
            <ul class="menu-list">
                <li><a :href="route('reviews.self')" :class="{ 'is-active': isActive('/self_reviews').value }">Self
                    Reviews</a></li>
                <li><a :href=" route('reviews.peer')" :class="{ 'is-active': isActive('/peer_reviews').value }">Peer
                    Reviews</a></li>
                <li v-if="user.role === 'Manager'"><a :href="route('reviews.manager')"
                                                      :class="{ 'is-active': isActive('/manager_reviews').value }">Manager
                    Reviews</a></li>
                <li v-if="user.view_rating_history"><a :href="route('user_ratings.my_history')"
                                                      :class="{ 'is-active': isActive('/my_history').value }">User Rating History</a></li>
            </ul>
            <div v-if="user.role === 'Manager'" class="mt-2">
                <p class="menu-label">Administration</p>
                <ul class="menu-list">
                    <li><a :href="route('categories.index')" :class="{ 'is-active': isActive('/categories').value }">Categories</a>
                    </li>
                    <li><a :href="route('users.index')" :class="{ 'is-active': isActive('/users').value }">Users</a>
                    </li>
                    <li><a :href="route('review_cycles.index')"
                           :class="{ 'is-active': isActive('/review_cycles').value }">Review Cycles</a></li>
                    <li><a :href="route('user_ratings.index')"
                           :class="{ 'is-active': isActive('/user_ratings').value }">User Ratings</a></li>
                </ul>
            </div>
        </aside>
    </div>
</template>

<style scoped>

</style>
