<template lang="html">
	<form class="form-horizontal">
		<div class="form-group" v-bind:class="{ 'has-error': urlError != '' }">
			<label for="url" class="col-md-4 control-label">Website URL</label>
			<div class="col-md-6">
				<input v-model="myPassword.url" type="text" id="url" name="url" required="required" class="form-control">
				<span class="help-block" v-show="urlError != ''"><strong>{{ urlError }}</strong></span>
			</div>

		</div>

		<div class="form-group" v-bind:class="{ 'has-error': usernameError != '' }">
			<label for="username" class="col-md-4 control-label">Username / Email</label>
			<div class="col-md-6">
				<input v-model="myPassword.username" type="text" id="username" name="username" required="required" class="form-control">
				<span class="help-block" v-show="usernameError != ''"><strong>{{ usernameError }}</strong></span>
			</div>
		</div>

		<div class="form-group" v-bind:class="{ 'has-error': passwordError != '' }">
			<label for="password" class="col-md-4 control-label">Password</label>
			<div class="col-md-6">
				<input v-model="myPassword.password" type="text" id="password" name="password" required="required" class="form-control" @keydown.enter="addPassword">
				<span class="help-block" v-show="passwordError != ''"><strong>{{ passwordError }}</strong></span>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
			    <div class="has-error">
			        <span class="help-block has-error" v-show="otherError != ''"><strong>{{ otherError }}</strong></span>
			    </div>
				<button type="button" class="btn btn-primary" @click="addPassword" v-show="!loading">
					{{ buttonText }}
				</button>
				<spinner v-show="loading"></spinner>
			</div>
		</div>
	</form>
</template>

<script>
	export default {
	    props: ['myPassword', 'method', 'buttonText'],
		data() {
			return {
                urlError: '',
                usernameError: '',
                passwordError: '',
                otherError: '',

                loading: false
			}
		},
		methods: {
			addPassword() {
			    this.loading = true;
			    this.resetErrors();

			    if (this.method === 'POST') {
			        axios.post('/user/password', this.myPassword, {
                        headers: { 'Authorization': "Bearer " + this.$localStorage.get('token') }
                    })
                        .then(this.successHandler)
                        .catch(this.errorHandler);
                } else if (this.method === 'PUT') {
                    axios.put('/user/password/' + this.myPassword.id, this.myPassword, {
                        headers: { 'Authorization': "Bearer " + this.$localStorage.get('token') }
                    })
                        .then(this.successHandler)
                        .catch(this.errorHandler);
                }
			},
            successHandler(response) {
			    this.loading = false;
                this.myPassword.id = response.data.id;
                this.$emit("success", this.myPassword);
            },
            errorHandler(error) {
			    this.loading = false;
                let data = error.response.data;

                if (Auth.isTokenValid(this, error)) {
                    if (error.response.status === 400) {
                        let errors = data.errors;
                        if (errors.url) {
                            this.urlError = errors.url[0];
                        }
                        if (errors.username) {
                            this.usernameError = errors.username[0];
                        }
                        if (errors.password) {
                            this.passwordError = errors.password[0];
                        }
                    } else if (error.response.status === 403) {
                        this.otherError = data.error;
                    }
                }
            },
            resetErrors() {
                this.urlError = '';
                this.usernameError = '';
                this.passwordError = '';
                this.otherError = '';
            },
		}
	};
</script>