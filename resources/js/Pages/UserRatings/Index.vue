<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RoundedLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import Pagination from "@/Components/Pagination.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faEye} from "@fortawesome/free-solid-svg-icons";

defineOptions({layout: AuthenticatedLayout});

defineProps({
    users: {
        type: Object,
    },
});
</script>

<template>
    <section class="section">
        <div class="is-flex mt-2 is-justify-content-space-between is-align-items-center">
            <h1 class="title has-text-primary m-0">User Ratings</h1>
        </div>
        <table class="table is-fullwidth ">
            <thead>
            <tr>
                <th><abbr title="Name">Name</abbr></th>
                <th><abbr title="Surname">Surname</abbr></th>
                <th><abbr title="Email">Email</abbr></th>
                <th><abbr title="Role">Role</abbr></th>
                <th><abbr title="Actions"></abbr></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users.data" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.surname }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role }}</td>
                <td>
                    <div class="is-flex">
                        <RoundedLinkButton class="is-rounded  mr-2" :href="route('user_ratings.show', user.id)">
                            <FontAwesomeIcon :icon="faEye"/>
                        </RoundedLinkButton>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :pagination="users"/>
    </section>
</template>
