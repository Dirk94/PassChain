<template lang="html">
	<div>
	    <!-- Add Password Panel -->
	    <div class="panel panel-default">
		    <div class="panel-heading">Add Password</div>
	        <div class="panel-body">
	            <add-password v-on:success='addPassword' :myPassword="emptyPassword" :method="'POST'" :buttonText="'Add Password'"></add-password>
		    </div>
	    </div>

	    <!-- Passwords -->
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Your Passwords</div>

                <div class="panel-body">
                    <transition-group name="list" mode="out-in" tag="div">
                        <div v-for="pass in passwords" v-bind:key="pass" class="password-container">
                            <div class="info-container">
                                <div class="title">{{ pass.url }}</div>
                                <p class="username">{{ pass.username }}</p>
                                <p class="password">{{ pass.password }}</p>
                            </div>
                            <div class="button-container">
                                <button type="button" class="btn btn-sm btn-default edit" data-toggle="modal" data-target="#editModal" @click="setEditPassword(pass)">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger delete" @click="showDeleteModal(pass)">Delete</button>
                            </div>
                        </div>
                    </transition-group>
                    <div v-show="passwords.length == 0">
                        <p>Nothing to see here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit password modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit Password</h4>
                    </div>
                    <div class="modal-body">
                        <add-password v-on:success="onEditPassword" :myPassword="editPassword" :method="'PUT'" :buttonText="'Save Changes'"></add-password>
                    </div>
                </div>
            </div>
        </div>

        <!-- Are you sure modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="confirmModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Password</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure that you want to delete this password?</p>
                        <div class="has-error" v-show="deleteError != ''">
                            <p class="help-block"><strong>{{ deleteError }}</strong></p>
                        </div>
                        <button type="button" class="btn btn-danger" @click="doDeletePassword" v-show="!deleteLoading">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" v-show="!deleteLoading">Cancel</button>
                        <spinner v-show="deleteLoading"></spinner>
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
				passwords: [],
                emptyPassword: {
				    id: -1,
                    url: '',
                    username: '',
                    password: ''
                },
                editPassword: {},

                deletePassword: {},
                deleteLoading: false,
                deleteError: ''
			}
		},
		methods: {
            addPassword(password) {
                this.passwords.push(password);
                this.emptyPassword = {
                    id: -1,
                    url: '',
                    username: '',
                    password: ''
                }
            },
            setEditPassword(password) {

                this.editPassword = {
                    id: password.id,
                    url: password.url,
                    username: password.username,
                    password: password.password
                };
            },
            onEditPassword(password) {
                for (let i=0; i<this.passwords.length; i++) {
                    if (this.passwords[i].id === password.id) {
                        this.passwords[i].url = password.url;
                        this.passwords[i].username = password.username;
                        this.passwords[i].password = password.password;
                    }
                }

                $("#editModal").modal('hide');
            },
            showDeleteModal(password) {
                this.deletePassword = password;
                this.passwordError = '';
                $("#confirmModal").modal('show');
            },
            doDeletePassword() {
                this.deleteLoading = true;
                this.deleteError = '';
                axios.delete("/user/password/" + this.deletePassword.id).then(response => {
                    this.deleteLoading = false;
                    this.passwords.splice(this.passwords.indexOf(this.deletePassword), 1);

                    $("#confirmModal").modal('hide');
                }).catch(error => {
                    this.deleteLoading = false;
                    this.deleteError = error.response.data.message;
                });
            },

            resetErrors() {
                this.urlError = '';
                this.usernameError = '';
                this.passwordError = '';
            },

		},
		created: function() {
			axios.get('/user/passwords', { headers: { 'Authorization': "Bearer " + this.$localStorage.get('token') }
            }).then(response => {
				this.passwords = response.data.passwords;
			}).catch(error => {
                Auth.isTokenValid(this, error);
            });
		}
	}
</script>

<style lang="css">
    .password-container {
        display: flex;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgb(211,224,233);
    }
    .password-container .title {
        font-weight: 600;
    }
    .password-container p {
        margin-bottom: 0;
        margin-top: 0;
    }
    .info-container {
        flex: 1;
    }
    .button-container {
        align-self: flex-end;
        width: 112px;
    }
    div.button-container button.edit {
        margin-right: 6px;
    }

    .list-enter-active, .list-leave-active {
        transition: all 1s;
    }
    .list-enter, .list-leave-to {
        opacity: 0;
        transform: translateY(30px);
    }
</style>


