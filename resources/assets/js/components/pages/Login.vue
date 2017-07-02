<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Login</h1>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">

                <div class="form-group" v-bind:class="{ 'has-error': error != '' }">
                    <label for="email" class="col-md-4 control-label">Email</label>
                    <div class="col-md-6">
                        <input v-model="email" type="text" id="email" class="form-control">
                    </div>
                </div>

                <div class="form-group" v-bind:class="{ 'has-error': error != '' }">
                    <label for="password" class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input v-model="password" type="password" id="password" class="form-control" @keydown.enter="submitLogin">
                        <div v-if="error" class="help-block"><strong>{{ error }}</strong></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div>
                            <button v-show="!loading" @click="submitLogin" type="button" class="btn btn-primary">Login</button>
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

                email: '',
                password: '',

                error: ''
            }
        },
        methods: {
            submitLogin() {
                this.loading = true;
                this.error = '';

                axios.post('/user/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    this.loading = false;

                    let data = response.data;
                    Auth.doLogin(this, data.token, data.name, data.email);
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.error;
                });
            }
        },
        created: function() {
            this.$emit('updateuserdetails');
        }

    }
</script>