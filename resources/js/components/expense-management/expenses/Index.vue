<template>
    <div class="container-fluid">
        <notifications group="notification" position="top right" />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-hover border">
                    <thead class="thead-dark">
                        <th>Expense Category</th>
                        <th>Amount</th>
                        <th>Entry Date</th>
                        <th>Created at</th>
                    </thead>
                    <tbody>
                        <tr v-if="Object.keys(expenses).length == 0">
                            <td>No record...</td>
                        </tr>
                        <tr v-else v-for="(expense, index) in expenses" :key="index" @click="btnEditExpense(expense.id)">
                            <td class="text-capitalize">{{expense.expense_category.name}}</td>
                            <td>{{expense.amount}}</td>
                            <td>{{expense.entry_date | moment("Y-M-D")}}</td>
                            <td>{{expense.created_at | moment("Y-M-D")}}</td>
                        </tr>
                    </tbody>
                </table>
                <button @click="btnAddExpense" class="float-right">Add Expense</button>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            Role
                        </div>
                        <div class="col-md-7">
                            <select v-model="expense.category" class="form-control text-capitalize">
                                <option disabled hidden value="">Select Role</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id" v-text="category.name"></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            Amount
                        </div>
                        <div class="col-md-7">
                            <input type="number" class="form-control" v-model="expense.amount">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            Entry Date
                        </div>
                        <div class="col-md-7">
                            <input type="date" class="form-control" v-model="expense.entry_date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" v-if="editMode" @click="deleteExpenses" class="btn btn-secondary mr-auto" >Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button v-if="!editMode" type="button" @click="storeExpense" class="btn btn-primary">Save</button>
                    <button v-else type="button" @click="updateExpenses" class="btn btn-primary">Update</button>
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
                expenses:{},
                editMode:false,
                id:'',
                categories:{},
                expense:new Form({
                    category:'',
                    amount:'',
                    entry_date:''
                }),
            }
        },
        methods: {
            index(){
                axios.get('/api/expense/index?api_token='+window.token)
                .then(res => {
                    console.log(res.data);
                    this.expenses = res.data.data;
                })
            },
            fetchAllCategory(){
                axios.get('/api/category/index?api_token='+window.token)
                .then(res => {
                    this.categories = res.data.data;
                })
            },
            btnAddExpense(){
                this.editMode = false;
                this.expense.category = '';
                this.expense.amount = '';
                this.expense.entry_date = '';
                $('#addExpenseModal').modal('show');
            },
            storeExpense(){
                if(this.expense.amount <= 0 || this.expense.entry_date == null || this.expense.category == ''){
                    this.$notify({
                        group: 'notification',
                        type:'error',
                        title: 'Invalid Input',
                        text: 'Please check your input if valid'
                    });
                }else{
                    this.expense.post('/api/expense/store?api_token='+window.token)
                    .then(res => {
                        this.$notify({
                            group: 'notification',
                            type:'success',
                            title: 'Add Expenses',
                            text: 'New Expenses has been added'
                        });
                        this.index();
                        this.expense.category = '';
                        this.expense.amount = '';
                        this.expense.entry_date = '';
                        $('#addExpenseModal').modal('hide');
                    });
                }
            },
            btnEditExpense(id){
                this.editMode = true;
                this.id = id;
                $('#addExpenseModal').modal('show');
                axios.get('/api/expense/show/'+id+'?api_token='+window.token)
                .then(res => {
                    this.expense.category = res.data.data.expense_category_id;
                    this.expense.amount = res.data.data.amount;
                    this.expense.entry_date = res.data.data.entry_date
                });
            },
            updateExpenses(){
                if(this.expense.amount <= 0 || this.expense.entry_date == null || this.expense.category == ''){
                    this.$notify({
                        group: 'notification',
                        type:'error',
                        title: 'Invalid Input',
                        text: 'Please check your input if valid'
                    });
                }else{
                    this.expense.put('/api/expense/update/'+this.id+'?api_token='+window.token)
                    .then(res => {
                        this.$notify({
                            group: 'notification',
                            type:'success',
                            title: 'Update Expenses',
                            text: 'Expenses has been updated'
                        });
                        this.index();
                        $('#addExpenseModal').modal('hide');
                    });
                }
            },

            deleteExpenses(){
                this.expense.delete('/api/expense/delete/'+this.id+'?api_token='+window.token)
                .then(res=>{
                    this.$notify({
                        group: 'notification',
                        type:'success',
                        title: 'Delete Expenses',
                        text: 'Expenses has been deleted'
                    });
                    this.index();
                    $('#addExpenseModal').modal('hide');
                });
            }
        },
        mounted() {
            this.index();
            this.fetchAllCategory();
        },
        
    }
</script>
