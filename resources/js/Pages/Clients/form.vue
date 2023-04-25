<template>
    <head> </head>
    <crud
        contentHeader="Client Manager"
        createTitle="Add new Client"
        updateTitle="Update Client"
        :urlUpdate="route('clients.update', form.id ? form.id : 0)"
        :urlStore="route('clients.store', form.id ? form.id : 0)"
        :urlDestroy="route('clients.destroy', form.id ? form.id : 0)"
        :form="form"
    >
        <!-- Name -->
        <div class="form-group w-75">
            <label for="client-name">Name</label>
            <input
                id="client-name"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                v-model="form.name"
            />
            <span class="invalid-feedback">{{ errors.name }}</span>
        </div>

        <!-- Email -->
        <div class="form-group w-50">
            <label for="client-email">Email</label>
            <input
                id="client-email"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.email }"
                v-model="form.email"
            />
            <div class="invalid-feedback">{{ errors.email }}</div>
        </div>

        <div class="form-group w-50">
            <label for="client-cpf">CPF</label>
            <input
                id="client-cpf"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.cpf }"
                v-model="form.cpf"
            />
            <div class="invalid-feedback">{{ errors.cpf }}</div>
        </div>

    </crud>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Crud from "@/Scriptpage/Content/Crud.vue";

export default {
    components: {
        Crud,
    },

    props: {
        errors: Object,
        data: Object,
    },

    data() {
        var data = this.data;
        return {
            form: useForm({
                id: data.id,
                name: data.name,
                email: data.email,
                cpf: data.cpf,
               
            }),
        };
    },

    mounted() {
    },
};
</script>
