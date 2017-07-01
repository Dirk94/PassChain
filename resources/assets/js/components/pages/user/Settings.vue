<template>
    <div class="panel panel-default">
        <div class="panel-heading">Settings</div>

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

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div>
                            <div v-if="success">
                                <div class="alert alert-success" role="alert">Changes saved.</div>
                            </div>

                            <button v-show="!loading" @click="submitSaveChanges" type="button" class="btn btn-primary">Save Changes</button>
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
                success: false,
                name: '',
                email: '',
                errors: {}
            }
        },
        methods: {
            submitSaveChanges() {
                this.loading = true;
                this.success = false;
                this.errors = {};

                let config = {
                    headers: {
                        'Authorization': "Bearer " + this.$localStorage.get('token')
                    }
                };

                axios.post('/user/settings', {
                    name: this.name,
                    email: this.email
                }, config).then(response => {
                    this.loading = false;
                    this.success = true;

                    let data = response.data;
                    this.$localStorage.set('name', data.name);
                    this.$localStorage.set('email', data.email);
                    this.$emit('updateuserdetails');
                }).catch(error => {
                    this.loading = false;

                    if (Auth.isTokenValid(this, error)) {
                        this.errors = error.response.data.errors;
                    }
                });
            }
        },
        created: function() {
            this.name = this.$localStorage.get('name');
            this.email = this.$localStorage.get('email');
        }
    }
</script>