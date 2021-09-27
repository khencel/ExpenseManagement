<?php

namespace App\Http\Controllers\API\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\ServicesController;
use App\Http\Traits\OutputTraits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use OutputTraits;

    public $services;
    public $model = '\User';

    public function __construct(
        ServicesController $services
    ){
        $this->services = $services;
    }

    public function index(){
        $relationship = "userRole.role";
        $role = $this->services->listDataWithRelationship($this->model,$relationship);
        return $this->returnSuccess('success',$role);
    }

    public function store(Request $request){
        // $subModel = '\HasRole';

        $data = array();
        $data['name']           =   $request->name;
        $data['email']          =   $request->email;
        $data['password']       =   Hash::make('password');
        $data['api_token']      =   Str::random(60);

        $user = $this->services->addData($data,$this->model);

        // $userRole['role_id']    =   $request->role['role'];
        // $userRole['model_type'] =   'App\Models\User';
        // $userRole['model_id']    =  $user->id;
        
        // $this->services->assignUserRole($userRole,$subModel);
        $user->assignRole($request->role['name']);
        return $this->returnSuccess('success',$user);
    }

    public function show($id){
        $relationship = "userRole.role";
        $user = $this->services->showDataWithRelationship($id,$this->model,$relationship);
        return $this->returnSuccess('success',$user);
    }

    public function update(Request $request,$id){
        $data = array();
        $data['name']           =   $request->name;
        $data['email']          =   $request->email;
        $user = $this->services->updateData($id,$data,$this->model);
        $user->syncRoles($request->role['name']);
        return $this->returnSuccess('success',$user);
    }

    public function delete($id){
        $subModel = '\userRole';
        
        $this->services->deleteRole($id,$subModel);
        $role = $this->services->deleteData($id,$this->model);
        return $this->returnSuccess('success',$role);
    }
}
