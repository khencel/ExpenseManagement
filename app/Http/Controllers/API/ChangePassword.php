<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\InvalidPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ChangePassword extends Controller
{
    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required',new InvalidPassword]
        ]);
    }

    public function passwordChange(Request $request){
        
        $password = $request->validate([
            'password' => ['required','confirmed'],
        ]);

        User::find(\Auth::user()->id)->update([
            'password' => Hash::make($request->password)
        ]);
    }
}
