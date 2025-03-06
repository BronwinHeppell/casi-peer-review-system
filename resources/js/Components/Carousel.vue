<template>
    <transition-group name="slide" tag="div" class="carousel-container">
        <div v-for="(slide, index) in slides" :key="slide.id" v-show="currentIndex === index" class="carousel-slide">
            <div class="slide-content is-flex is-align-items-center is-justify-content-center">
                <div class="columns is-vcentered">
                    <div class="column is-full-mobile is-half-desktop image-column">
                        <figure class="image is-covered">
                            <img :src="slide.imageUrl" :alt="slide.title" class="slide-image">
                        </figure>
                    </div>
                    <div class="content-wrapper">
                        <h1 class="title is-2 has-text-weight-bold has-text-primary">{{ slide.title }}</h1>
                        <h2 class="subtitle is-4">{{ slide.subtitle }}</h2>
                        <p class="content is-size-5">{{ slide.description }}</p>
                    </div>
                </div>
            </div>

            <div class="pagination-controls">
                <div class="pagination">
                    <span v-for="(dot, i) in slides.length" :key="i" class="dot"
                        :class="{ 'active': currentIndex === i }" @click="goToSlide(i)"></span>
                </div>
            </div>
        </div>
    </transition-group>

</template>

<script>
export default {
    name: 'OnboardingCarousel',
    data() {
        return {
            currentIndex: 0,
            autoSlideInterval: null,
            autoSlideDelay: 5000,
            email: '',
            password: '',
            slides: [
                {
                    id: 1,
                    title: 'Welcome to Our Platform',
                    subtitle: 'Start your journey',
                    description: 'Discover how our platform can help you achieve your goals.',
                    imageUrl: 'https://placehold.co/600x400',
                },
                {
                    id: 2,
                    title: 'Dashboard Overview',
                    subtitle: 'Your command center',
                    description: 'Track your progress in real-time with insights and analytics.',
                    imageUrl: 'https://placehold.co/600x400',
                },
                {
                    id: 3,
                    title: 'Task Management',
                    subtitle: 'Stay organized',
                    description: 'Efficiently create, assign, and track tasks.',
                    imageUrl: 'https://placehold.co/600x400',
                },
                {
                    id: 4,
                    title: 'Collaboration Tools',
                    subtitle: 'Work together',
                    description: 'Connect with your team using messaging and file sharing.',
                    imageUrl: 'https://placehold.co/600x400',
                },
                {
                    id: 5,
                    title: "You're All Set!",
                    subtitle: 'Ready to begin',
                    description: 'Your account is now ready to use!',
                    imageUrl: 'https://placehold.co/600x400',
                }
            ]
        };
    },
    methods: {
        startAutoSlide() {
            this.autoSlideInterval = setInterval(() => {
                this.nextSlide();
            }, this.autoSlideDelay);
        },
        stopAutoSlide() {
            clearInterval(this.autoSlideInterval);
        },
        nextSlide() {
            this.currentIndex = this.currentIndex < this.slides.length - 1 ? this.currentIndex + 1 : 0;
        },
        goToSlide(index) {
            this.currentIndex = index;
            this.stopAutoSlide();
            this.startAutoSlide();
        },
        handleLogin() {
            // Add your login logic here
            console.log('Login attempted with:', this.email, this.password);
        }
    },
    mounted() {
        this.startAutoSlide();
    },
    beforeUnmount() {
        this.stopAutoSlide();
    }
};
</script>

<style scoped>
.carousel-half {
    margin: 0;
    height: 100%;
}

@media screen and (min-width: 1024px) {
    .carousel-half {
        width: 50%;
    }
}

.carousel-container {
    width: 100%;
    height: 100%;
    position: relative;
}

.carousel-slide {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 3rem;
    box-sizing: border-box;
    transition: background-color 0.5s ease;
}

.slide-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 1200px;
    margin: 0 auto;
}

.content-wrapper {
    padding: 2rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.image-column {
    display: flex;
    justify-content: center;
    align-items: center;
}

.is-covered {
    width: 100%;
    height: 100%;
    max-height: 400px;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

.slide-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.pagination-controls {
    display: flex;
    justify-content: center;
    padding: 1.5rem 0;
}

.pagination {
    display: flex;
    gap: 10px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.2);
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid var(--bulma-primary);
}

.dot:hover {
    background-color: rgba(66, 133, 244, 0.5);
}

.dot.active {
    background-color: var(--bulma-primary);
    transform: scale(1.2);
}

/* Transitions */
.slide-enter-active,
.slide-leave-active {
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.slide-enter-from {
    opacity: 0;
    transform: translateX(80px);
}

.slide-leave-to {
    opacity: 0;
    transform: translateX(-80px);
}

/* Responsive Adjustments */
@media screen and (max-width: 1023px) {
    .carousel-slide {
        padding: 2rem 1.5rem;
    }

    .content-wrapper {
        padding: 1.5rem;
    }
}

@media screen and (max-width: 768px) {
    .columns {
        flex-direction: column-reverse;
    }

    .column {
        padding: 0.75rem;
    }
}
</style>