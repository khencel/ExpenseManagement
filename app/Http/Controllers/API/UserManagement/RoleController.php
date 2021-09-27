<?php

namespace App\Http\Controllers\API\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\ServicesController;
use App\Http\Traits\OutputTraits;

class RoleController extends Controller
{
    use OutputTraits;

    public $services;
    public $model = '\Role';

    public function __construct(
        ServicesController $services
    ){
        $this->services = $services;
    }

    public function index(){
        $role = $this->services->listData($this->model);
        return $this->returnSuccess('success',$role);
    }

    public function store(Request $request){
        $data = array();
        $data['name']           =   $request->name;
        $data['guard_name']     =   "web";
        $data['description']    =   $request->description;
        $role = $this->services->addData($data,$this->model);
        return $this->returnSuccess('success',$role);
    }

    public function show($id){
        $role = $this->services->showData($id,$this->model);
        return $this->returnSuccess('success',$role);
    }

    public function update(Request $request,$id){
        $data = array();
        $data['name']           =   $request->name;
        $data['guard_name']     =   "web";
        $data['description']    =   $request->description;
        $role = $this->services->updateData($id,$data,$this->model);
        return $this->returnSuccess('success',$role);
    }

    public function delete($id){
        $role = $this->services->deleteData($id,$this->model);
        return $this->returnSuccess('success',$role);
    }
}
