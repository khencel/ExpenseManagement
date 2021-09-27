<template>
    <div class="container-fluid">
        <notifications group="notification" position="top right" />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-hover border">
                    <thead class="thead-dark">
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Created at</th>
                    </thead>
                    <tbody>
                        <tr v-for="(role, index) in roles" :key="index" @click="role.id != 1?btnEditRole(role.id):''">
                            <td>{{role.name}}</td>
                            <td>{{role.description}}</td>
                            <td>{{role.created_at | moment("Y-M-D")}}</td>
                        </tr>
                    </tbody>
                </table>
                <button @click="btnAddRole" class="float-right">Add Role</button>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            Display Name
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="role.name">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            Description
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="role.description">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" v-if="editMode" @click="deleteRole" class="btn btn-secondary mr-auto" >Delete</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button v-if="!editMode" type="button" @click="storeRole" class="btn btn-primary">Save</button>
                    <button v-else type="button" @click="updateRole" class="btn btn-primary">Update</button>
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
                roles:{},
                editMode:false,
                id:'',
                role:new Form({
                    name:'',
                    description:''
                }),
            }
        },
        methods: {
            index(){
                axios.get('/api/role/index?api_token='+window.token)
                .then(res => {
                    this.roles = res.data.data;
                })
            },
            btnAddRole(){
                this.editMode = false;
                this.role.name = '';
                this.role.description = '';
                $('#addRoleModal').modal('show');
            },
            storeRole(){
                this.role.post('/api/role/store?api_token='+window.token)
                .then(res => {
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Add Role',
                        text: 'New Role has been added'
                    });
                    this.index();
                    this.role.name = '';
                    this.role.description = '';
                    $('#addRoleModal').modal('hide');
                });
            },
            btnEditRole(id){
                this.editMode = true;
                this.id = id;
                $('#addRoleModal').modal('show');
                axios.get('/api/role/show/'+id+'?api_token='+window.token)
                .then(res => {
                    this.role.name = res.data.data.name;
                    this.role.description = res.data.data.description;
                });
            },
            updateRole(){
                this.role.put('/api/role/update/'+this.id+'?api_token='+window.token)
                .then(res => {
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Update Role',
                        text: 'Role has been updated'
                    });
                    this.index();
                    $('#addRoleModal').modal('hide');
                });
            },

            deleteRole(){
                this.role.delete('/api/role/delete/'+this.id+'?api_token='+window.token)
                .then(res=>{
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Delete Role',
                        text: 'Role has been deleted'
                    });
                    this.index();
                    $('#addRoleModal').modal('hide');
                });
            }
        },
        mounted() {
            this.index();
        },
        
    }
</script>
