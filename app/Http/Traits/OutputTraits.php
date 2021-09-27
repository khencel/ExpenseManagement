<?php

namespace App\Http\Traits;

trait OutputTraits
{
   public function returnSuccess($message,$data){
       return response()->json([
           'message'    =>      $message,
           'data'       =>      $data,
           'code'       =>      200   
       ]);
   }
}
