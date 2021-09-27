<template>
<div class="mt-5">
    <notifications group="notification" position="bottom right" />
    <div class="row m-0">
        <div class="col-md-6 border p-3 bg-white">
            <p class="font-weight-bold">Current Password</p>
            <input type="password" class="form-control" v-model="form.current_password" autofocus placeholder="Enter your current password">
            <span class="text-danger font-italic" v-if="errors.current_password" v-text="errors.current_password[0]"></span>
            <button class="mt-2 float-right buttonSuccess" @click="btnSubmit">Submit</button>
        </div>
        <div class="col-md-6 border p-3 bg-white">
            <p class="font-weight-bold">Change your password</p>
            <div>
                <label for="">New Password</label>
                <input type="password" :readonly="readonly" class="form-control" v-model="form.password" autofocus placeholder="Enter your new password">
                <span class="text-danger font-italic" v-if="errors.password" v-text="errors.password[0]"></span>
            </div>
            <div class="mt-2">
                <label for="">Confirm New Password</label>
                <input type="password" :readonly="readonly" class="form-control" v-model="form.password_confirmation" autofocus placeholder="Enter your new password">
            </div>
            <div class="mt-2 text-right">
                <button class="buttonSuccess" @click="btnChangePassword">Change Password</button>
            </div>
        </div>
    </div>
</div>
    
</template>

<script>
    export default {
        data(){
            return{
               readonly:true,
               errors:{},
               form:new Form({
                   current_password:'',
                   password:''
               }),
            }
        },  
        mounted() {
            console.log('change password');
        },
        methods:{
            btnSubmit(){
                this.form.post('/api/change-password?api_token='+window.token)
                .then(response => {
                    this.errors = [];
                    this.readonly = false;
                })
                .catch(error => 
                {
                    this.errors = error.response.data.errors;
                });
            },

            btnChangePassword(){
                this.form.post('/api/password-change?api_token='+window.token)
                .then(response => {
                    this.errors = [];
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Update Password',
                        text: 'Password has been changed'
                    });
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            }
        }
    }
</script>
