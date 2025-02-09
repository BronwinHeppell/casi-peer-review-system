
<script>
export default {
    props: {
        isActive: {
            type: Boolean,
            required: true,
        },
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        confirmDelete() {
            this.$emit("confirm");
        },
    },
};
</script>

<template>
    <div class="modal" :class="{ 'is-active': isActive }">
        <div class="modal-background" @click="closeModal"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Confirm Deletion</p>
                <button class="delete" aria-label="close" @click="closeModal"></button>
            </header>
            <section class="modal-card-body">
                <p>Are you sure you want to delete this item?</p>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-danger mr-4" @click="confirmDelete">Delete</button>
                <button class="button" @click="closeModal">Cancel</button>
            </footer>
        </div>
    </div>
</template>


<style scoped>
.modal-card {
    max-width: 400px;
    margin: auto;
}
</style>
