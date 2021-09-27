<template>
    <div class="container-fluid">
        <notifications group="notification" position="top right" />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-hover border">
                    <thead class="thead-dark">
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Created at</th>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :key="index" @click="user.user_role.role_id != 1?btnEditUser(user.id):''">
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.user_role != null?user.user_role.role.name:'none'}}</td>
                            <td>{{user.created_at | moment("Y-M-D")}}</td>
                        </tr>
                    </tbody>
                </table>
                <button @click="btnAddUser" class="float-right">Add User</button>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            Name
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="user.name">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            Email Address
                        </div>
                        <div class="col-md-7">
                            <input type="email" class="form-control" v-model="user.email">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            Role
                        </div>
                        <div class="col-md-7">
                            <select v-model="user.role" class="form-control text-capitalize">
                                <option disabled hidden value="">Select Role</option>
                                <option v-for="(role, index) in roles" :key="index" :value="{role:role.id,name:role.name}" v-text="role.name"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" v-if="editMode" @click="deleteUser" class="btn btn-secondary mr-auto" >Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button v-if="!editMode" type="button" @click="storeUser" class="btn btn-primary">Save</button>
                    <button v-else type="button" @click="updateUser" class="btn btn-primary">Update</button>
                </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                users:{},
                editMode:false,
                id:'',
                roles:{},
                user:new Form({
                    name:'',
                    email:'',
                    role:{}
                }),
            }
        },
        methods: {
            index(){
                axios.get('/api/user/index?api_token='+window.token)
                .then(res => {
                    this.users = res.data.data;
                    console.log(res.data);
                })
            },
            fetchAllRole(){
                axios.get('/api/role/index?api_token='+window.token)
                .then(res => {
                    this.roles = res.data.data;
                })
            },
            btnAddUser(){
                this.editMode = false;
                this.user.name = '';
                this.user.email = '';
                this.user.role = '';
                $('#addUserModal').modal('show');
            },
            storeUser(){
                this.user.post('/api/user/store')
                .then(res => {
                    console.log(res.data);
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Add User',
                        text: 'New User has been added'
                    });
                    this.index();
                    this.user.name = '';
                    this.user.email = '';
                    this.user.role = '';
                    $('#addUserModal').modal('hide');
                });
            },
            btnEditUser(id){
                this.editMode = true;
                this.id = id;
                $('#addUserModal').modal('show');
                axios.get('/api/user/show/'+id+'?api_token='+window.token)
                .then(res => {
                    console.log(res.data);
                    this.user.name = res.data.data.name;
                    this.user.email = res.data.data.email;
                    this.user.role = {
                                        role:res.data.data.user_role.role.id,
                                        name:res.data.data.user_role.role.name
                                    }
                });
            },
            updateUser(){
                this.user.put('/api/user/update/'+this.id+'?api_token='+window.token)
                .then(res => {
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Update User',
                        text: 'User has been updated'
                    });
                    this.index();
                    $('#addUserModal').modal('hide');
                });
            },

            deleteUser(){
                this.user.delete('/api/user/delete/'+this.id+'?api_token='+window.token)
                .then(res=>{
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Delete User',
                        text: 'User has been deleted'
                    });
                    this.index();
                    $('#addUserModal').modal('hide');
                });
            }
        },
        mounted() {
            this.index();
            this.fetchAllRole();
        },
        
    }
</script>
