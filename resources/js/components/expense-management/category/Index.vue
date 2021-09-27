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
                        <tr v-if="Object.keys(categories).length == 0">
                            <td>No record...</td>
                        </tr>
                        <tr v-else v-for="(category, index) in categories" :key="index" @click="btnEditCategory(category.id)">
                            <td>{{category.name}}</td>
                            <td>{{category.description}}</td>
                            <td>{{category.created_at | moment("Y-M-D")}}</td>
                        </tr>
                    </tbody>
                </table>
                <button @click="btnAddCategory" class="float-right">Add Category</button>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
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
                            <input type="text" class="form-control" v-model="category.name">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            Description
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="category.description">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" v-if="editMode" @click="deleteCategory" class="btn btn-secondary mr-auto" >Delete</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button v-if="!editMode" type="button" @click="storeCategory" class="btn btn-primary">Save</button>
                    <button v-else type="button" @click="updateCategory" class="btn btn-primary">Update</button>
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
                categories:{},
                editMode:false,
                id:'',
                category:new Form({
                    name:'',
                    description:''
                }),
            }
        },
        methods: {
            index(){
                axios.get('/api/category/index?api_token='+window.token)
                .then(res => {
                    this.categories = res.data.data;
                })
            },
            btnAddCategory(){
                this.editMode = false;
                this.category.name = '';
                this.category.description = '';
                $('#addCategoryModal').modal('show');
            },
            storeCategory(){
                this.category.post('/api/category/store?api_token='+window.token)
                .then(res => {
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Add Category',
                        text: 'New Category has been added'
                    });
                    this.index();
                    this.category.name = '';
                    this.category.description = '';
                    $('#addCategoryModal').modal('hide');
                });
            },
            btnEditCategory(id){
                this.editMode = true;
                this.id = id;
                $('#addCategoryModal').modal('show');
                axios.get('/api/category/show/'+id+'?api_token='+window.token)
                .then(res => {
                    this.category.name = res.data.data.name;
                    this.category.description = res.data.data.description;
                });
            },
            updateCategory(){
                this.category.put('/api/category/update/'+this.id+'?api_token='+window.token)
                .then(res => {
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Update Category',
                        text: 'Category has been updated'
                    });
                    this.index();
                    $('#addCategoryModal').modal('hide');
                });
            },

            deleteCategory(){
                this.category.delete('/api/category/delete/'+this.id+'?api_token='+window.token)
                .then(res=>{
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Delete Category',
                        text: 'Category has been deleted'
                    });
                    this.index();
                    $('#addCategoryModal').modal('hide');
                });
            }
        },
        mounted() {
            this.index();
        },
        
    }
</script>
