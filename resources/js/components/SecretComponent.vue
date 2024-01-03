<template>
    <PageStructure hideSidebar>
        <div class="container-fluid d-flex align-items-center justify-content-center vh-100">
            <div class="w-25">
                <form @submit.prevent="handleLogin" class="card p-4 shadow d-flex flex-column gap-3">
                    <h2 class="mb-4">Login</h2>
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" v-model="formData.email"
                            placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" v-model="formData.password"
                            placeholder="Enter your password">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Entrar</button>
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
            secrets: [],
            formData: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        handleLogin() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {
                email: this.formData.email,
                password: this.formData.password
                }
                ).then(response => {
                    this.$router.push({ name: 'studentIndex' });
                }).catch(error => {
                    this.$swal({
                        title: 'Error',
                        text: 'Email ou senha incorretos',
                        icon: 'error'
                    });
                });
            });
        },
        getSecrets() {
            axios.get('/api/secrets').then(response => this.secrets = response.data);
        }
    }
}
</script>