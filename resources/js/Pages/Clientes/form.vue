<template>
    <head> </head>
    <crud
        contentHeader="Cliente"
        createTitle="Cadastro de Cliente"
        updateTitle="Atualizar Cliente"
        :urlUpdate="route('clientes.update', form.id ? form.id : 0)"
        :urlStore="route('clientes.store', form.id ? form.id : 0)"
        :urlDestroy="route('clientes.destroy', form.id ? form.id : 0)"
        :form="form"
    >
        <!-- Name -->
        <div class="form-group w-75">
            <label for="cliente-name">Name</label>
            <input
                id="cliente-name"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                v-model="form.name"
            />
            <span class="invalid-feedback">{{ errors.name }}</span>
        </div>

        <!-- Email -->
        <div class="form-group w-50">
            <label for="cliente-email">Email</label>
            <input
                id="user-email"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.email }"
                v-model="form.email"
            />
            <div class="invalid-feedback">{{ errors.email }}</div>
        </div>
        <!-- CPF -->
        <div class="form-group w-50">
            <label for="cliente-cpf">CPF</label>
            <input
                id="cliente-cpf"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.cpf }"
                v-model="form.cpf"
            />
            <div class="invalid-feedback">{{ errors.cpf }}</div>
        </div>

        <div class="form-group w-50">
            <label for="cliente-telephone">Telefone</label>
            <input
                id="cliente-telephone"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.telephone }"
                v-model="form.telephone"
            />
            <div class="invalid-feedback">{{ errors.telephone }}</div>
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
            }),
        };
    },
};
</script>
