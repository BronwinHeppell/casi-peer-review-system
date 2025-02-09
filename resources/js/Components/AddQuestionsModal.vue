<script>
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";
import InputError from "@/Components/form/InputError.vue";
import {useForm} from "@inertiajs/vue3";

export default {
    components: {InputError, TextInput, InputLabel},
    props: {
        isActive: {
            type: Boolean,
            required: true,
        },
        question: {
            type: Object,
            default: null,
        }
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

const form = useForm(
    {
        title: this.question?.title || "",
    }
);

</script>

<template>
    <div class="modal" :class="{ 'is-active': isActive }">
        <div class="modal-background" @click="closeModal"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Add New Question</p>
                <button class="delete" aria-label="close" @click="closeModal"></button>
            </header>
            <section class="modal-card-body">
                <form>
                    <!--TITLE-->
                    <div class="container mt-4">
                        <InputLabel for="title" value="Title"></InputLabel>
                        <TextInput
                            id="title"
                            class="mt-1"
                            v-model="form.title"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.title"/>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-primary mr-4" @click="confirmDelete">Save</button>
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
