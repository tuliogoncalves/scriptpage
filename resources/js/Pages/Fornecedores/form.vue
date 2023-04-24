<template>
    <head> </head>
    <crud
        contentHeader="User Manager"
        createTitle="Add new User"
        updateTitle="Update User"
        :urlUpdate="route('users.update', form.id ? form.id : 0)"
        :urlStore="route('users.store', form.id ? form.id : 0)"
        :urlDestroy="route('users.destroy', form.id ? form.id : 0)"
        :form="form"
    >
        <!-- Name -->
        <div class="form-group w-75">
            <label for="user-name">Name</label>
            <input
                id="user-name"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                v-model="form.name"
            />
            <span class="invalid-feedback">{{ errors.name }}</span>
        </div>

        <!-- Email -->
        <div class="form-group w-50">
            <label for="user-email">Email</label>
            <input
                id="user-email"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.email }"
                v-model="form.email"
            />
            <div class="invalid-feedback">{{ errors.email }}</div>
        </div>

        <!-- Roles -->
        <div class="form-group">
            <label>Roles</label>
            <select
                id="user-roles"
                class="form-control select2"
                multiple="multiple"
                name="user-roles"
                data-placeholder="Select a Roles"
            >
                <option
                    v-for="role in $page.props.flash.user.listOfRoles"
                    :value="role.id"
                >
                    {{ role.name }}
                </option>
            </select>
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
                roles: [],
            }),
        };
    },

    mounted() {
        var userRoles = $("#user-roles");
        var data = this.data;
        var form = this.form;

        //Initialize Select2 Elements
        userRoles.select2();

        // Trigger
        userRoles.on("change", function (e) {
            form.roles = userRoles.val();
        });

        var roles = null;

        // Filtre name roles
        if (data.roles) {
            var roles = data.roles.map(function (obj) {
                return obj.name;
            });
        }

        // Set value to select2 filed
        userRoles.val(roles);
        userRoles.trigger("change");

        userRoles.on("change", function (e) {
            form.roles = userRoles.val();
        });
    },
};
</script>
