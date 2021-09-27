<template>
  <div>
    <h2>My Expenses</h2>
      <div class="row bg-white">
          <div class="col-md-4">
              <table class="table table-hover border mt-5">
                  <thead class="thead-dark">
                      <th>Expense Categories</th>
                      <th>Total</th>
                  </thead>
                  <tbody>
                      <tr v-for="(expense, index) in expenses" :key="index">
                            <td>{{expense.expense_category.name}}</td>
                            <td>${{expense.amount}}</td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="col-md-8">
               <GChart
                type="PieChart"
                :options="options"
                :data="data"
                /> 
          </div>
      </div>
  </div>
</template>
 
<script>
import { GChart } from "vue-google-charts";

export default {
  name: "App",
  components: {
    GChart
  },
  data() {
    return {
        expenses:{},
        data: [
            ['Category', 'Expenses'],
        ],
        options: {
        width: 1100,
        height: 400
        }
    };
    
  },
    mounted() {
        this.fetchExpense();
    },
    methods: {
        fetchExpense(){
            axios.get('/api/home?api_token='+window.token)
            .then(res => {
                console.log(res.data);
                this.expenses = res.data.data;
                res.data.data.forEach(element => {
                    this.data.push([
                        element.expense_category.name,
                        element.amount
                    ]);
                });
            });
        }

    },
};
</script>