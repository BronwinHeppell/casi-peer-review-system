<script setup>
import Carousel from '@/Components/Carousel.vue';
import Login from '../Auth/Login.vue';

</script>

<template>
    <div class="landing-container is-fullwidth is-flex is-fullheight">
        <div class="carousel-half">
            <Carousel />
        </div>
        <div class="login-half">
            <div class="login-container">
                <Login />
            </div>
        </div>
    </div>
</template>

<style scoped>
.landing-container {
    display: flex;
    height: 95vh;
    background-color: #ffffff;
    overflow-y: hidden;
}

.carousel-half {
    width: 60%;
    height: 100%;
}

.login-half {
    width: 40%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-container {
    width: 100%;
    max-width: 500px;
}


@media screen and (max-width: 1024px) {
    .carousel-half {
        display: none;
    }

    .login-half {
        width: 100%;
        height: 100%;
        padding: 12px;
    }
}
</style>
