<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\OutputTraits;
use App\Models\Expense;
use DB;

class HomeController extends Controller
{
    use OutputTraits;
    public function getExpenseSummary(){
        $expenses = Expense::with('expenseCategory')->where('user_id',\Auth::user()->id)
                            ->select('expense_category_id',
                                DB::raw("(sum(amount)) as amount")
                            )
                            ->groupBy('expense_category_id')
                            ->get();        
        return $this->returnSuccess('success',$expenses);
    }
}
