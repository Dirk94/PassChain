<template>
    <div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Navigation</div>

                <div class="panel-body">
                    <ul>
                        <li><router-link to="/user">Passwords</router-link></li>
                        <li><router-link to="/user/settings">Settings</router-link></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <transition name="fade" mode="out-in">
                <router-view v-on:updateuserdetails="updateUserDetails()"></router-view>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            updateUserDetails() {
                this.$emit('updateuserdetails');
            }
        }
    }
</script>

<style lang="css">
    ul {
        list-style-type: none;
        padding-left: 0;
    }

    ul li {
        margin-bottom: 4px;
    }
</style>