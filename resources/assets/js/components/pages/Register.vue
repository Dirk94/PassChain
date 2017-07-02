<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Register</h1>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group" v-bind:class="{ 'has-error': errors.name }">
                    <label for="name" class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input v-model="name" type="text" id="name" class="form-control">
                        <div v-if="errors.name" class="help-block"><strong>{{ errors.name[0] }}</strong></div>
                    </div>
                </div>

                <div class="form-group" v-bind:class="{ 'has-error': errors.email }">
                    <label for="email" class="col-md-4 control-label">Email</label>
                    <div class="col-md-6">
                        <input v-model="email" type="text" id="email" class="form-control">
                        <div v-if="errors.email" class="help-block"><strong>{{ errors.email[0] }}</strong></div>
                    </div>
                </div>

                <div class="form-group" v-bind:class="{ 'has-error': errors.password }">
                    <label for="password" class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input v-model="password" type="password" id="password" class="form-control">
                        <div v-if="errors.password" class="help-block"><strong>{{ errors.password[0] }}</strong></div>
                    </div>
                </div>

                <div class="form-group" v-bind:class="{ 'has-error': errors.confirmPassword }">
                    <label for="confirm-password" class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-6">
                        <input v-model="confirmPassword" type="password" id="confirm-password" class="form-control" @keydown.enter="submitRegister">
                        <div v-if="errors.confirmPassword" class="help-block"><strong>{{ errors.confirmPassword[0] }}</strong></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div>
                            <button v-show="!loading" @click="submitRegister" type="button" class="btn btn-primary">Register</button>
                            <spinner v-show="loading"></spinner>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                loading: false,

                name: '',
                email: '',
                password: '',
                confirmPassword: '',

                errors: {}
            }
        },

        methods: {
            submitRegister() {
                this.loading = true;
                this.errors = {};

                if (this.password !== this.confirmPassword) {
                    this.errors.confirmPassword = ["The passwords don't match."];
                    return;
                }

                axios.post('/user/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                }).then(response => {
                    this.loading = false;

                    let data = response.data;
                    Auth.doLogin(this, data.token, data.name, data.email);
                }).catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
            }
        }
    }
</script>