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

        <!-- CPF -->
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
        <!-- Data de Nascimento -->
        <div class="form-group w-50">
            <label for="client-birth">Data de Nascimento</label>
            <input
                id="client-birth"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.birth }"
                v-model="form.birth"
            />
            <div class="invalid-feedback">{{ errors.birth }}</div>
        </div>
        <!-- Numero de Telefone -->
        <div class="form-group w-50">
            <label for="client-tel_num">Telefone</label>
            <input
                id="client-tel_num"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.tel_num }"
                v-model="form.tel_num"
            />
            <div class="invalid-feedback">{{ errors.tel_num }}</div>
        </div>
        <!-- CEP -->
        <div class="form-group w-50">
            <label for="client-cep">CEP</label>
            <input
                id="client-cep"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.cep }"
                v-model="form.cep"
            />
            <div class="invalid-feedback">{{ errors.cep }}</div>
        </div>
        <!-- Estado -->
        <div class="form-group w-50">
            <label for="client-state">Estado</label>
            <input
                id="client-state"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.state }"
                v-model="form.state"
            />
            <div class="invalid-feedback">{{ errors.state }}</div>
        </div>
        <!-- Cidade -->
        <div class="form-group w-50">
            <label for="client-city">Cidade</label>
            <input
                id="client-city"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.city }"
                v-model="form.city"
            />
            <div class="invalid-feedback">{{ errors.city }}</div>
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
                cpf: data.cpf,
                email: data.email,
                birth: data.birth,
                tel_num: data.tel_num,
                cep: data.cep,
                state: data.state,
                city: data.city,
               
            }),
        };
    },

    mounted() {
    },
};
</script>
