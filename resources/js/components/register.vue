<template>
    <PageStructure hideSidebar>
        <div class="container-fluid d-flex align-items-center justify-content-center vh-100">
            <div class="w-25">
                <form @submit.prevent="register" class="card p-4 shadow d-flex flex-column gap-3">
                    <h2 class="mb-4">Registro</h2>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" v-model="formData.name"
                            placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" v-model="formData.email"
                            placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="inputPassword" v-model="formData.password"
                            placeholder="Enter your password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmPassword" v-model="formData.confirmPassword"
                            placeholder="Confirm your password">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </PageStructure>
</template>

<script>
import axios from 'axios';
import PageStructure from './pageStructure.vue';

export default {
    components: {
        PageStructure
    },
    data() {
        return {
            formData: {
                name: '',
                email: '',
                password: '',
                confirmPassword: ''
            }
        }
    },
    methods: {
        register() {
            if (this.formData.password !== this.formData.confirmPassword) {
                this.$swal({
                    title: 'Erro',
                    text: 'As senhas não correspondem',
                    icon: 'error'
                });
                return;
            }

            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    name: this.formData.name,
                    email: this.formData.email,
                    password: this.formData.password
                }).then(response => {
        
                    this.$router.push({ name: 'studentIndex' });
                }).catch(error => {
                    this.$swal({
                        title: 'Erro',
                        text: 'Falha no registro. Por favor, tente novamente.',
                        icon: 'error'
                    });
                });
            });
        }
    }
}
</script>
