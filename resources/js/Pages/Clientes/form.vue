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
    <div class="d-flex justify-content-between flex-wrap">
        <!-- Name -->
        <div class="form-group w-50">
            <label for="cliente-name">Nome</label>
            <input
                id="cliente-name"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                v-model="form.name"
            />
            <span class="invalid-feedback">{{ errors.name }}</span>
        </div>

        <!-- CPF -->
        <div class="form-group w-40">
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
        <!-- Email -->
        <div class="form-group w-40">
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

        <div class="form-group w-40">
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

        <div class="form-group w-30">
            <label for="cliente-birth">Data de Nascimento</label>
            <input
                id="cliente-birth"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.birth }"
                v-model="form.birth"
            />
            <div class="invalid-feedback">{{ errors.birth }}</div>
        </div>

        <div class="form-group w-50">
            <label for="cliente-state">Estado</label>
            <input
                id="cliente-state"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.state }"
                v-model="form.state"
            />
            <div class="invalid-feedback">{{ errors.state }}</div>
        </div>
        <!-- TELEFONE -->
        <div class="form-group w-50">
            <label for="cliente-city">Cidade</label>
            <input
                id="cliente-city"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.city }"
                v-model="form.city"
            />
            <div class="invalid-feedback">{{ errors.city }}</div>
        </div>

        <div class="form-group w-50">
            <label for="cliente-address">Endereço</label>
            <input
                id="cliente-address"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.address }"
                v-model="form.address"
            />
            <div class="invalid-feedback">{{ errors.address }}</div>
        </div>
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
                telephone: data.telephone,
                birth: data.birth,
                state: data.state,
                city: data.city,
                address: data.address,
            }),
        };
    },
};
</script>
