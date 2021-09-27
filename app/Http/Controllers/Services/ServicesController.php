<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public $modelPath = 'App\Models';
    
    public function listData($currentModel){
        $model = $this->modelPath.$currentModel;
        return $model::all();
    }

    public function listDataWithRelationship($currentModel,$rel){
        $model = $this->modelPath.$currentModel;
        return $model::with($rel)->get();
    }

    public function fetchByField($value,$field,$currentModel){
        $model = $this->modelPath.$currentModel;
        return $model::where($field,$value)->get();
    }

    public function fetchByFieldWithRelationship($value,$rel,$field,$currentModel){
        $model = $this->modelPath.$currentModel;
        return $model::with($rel)->where($field,$value)->get();
    }

    public function addData($data,$currentModel){
        $model = $this->modelPath.$currentModel;
        return $model::create($data);
    }

    public function showData($id,$currentModel){
        $model = $this->modelPath.$currentModel;
        return $model::find($id);
    }

    public function showDataWithRelationship($id,$currentModel,$rel){
        $model = $this->modelPath.$currentModel;
        return $model::with($rel)->find($id);
    }

    public function updateData($id,$data,$currentModel){
        $model = $this->modelPath.$currentModel;
        $role = $model::find($id);
        $role->update($data);
        return $role;
    }

    public function deleteData($id,$currentModel){
        
        $model = $this->modelPath.$currentModel;
        $role = $model::find($id)->delete();
        return $role;
    }

    public function deleteRole($id,$currentModel){
        $model = $this->modelPath.$currentModel;
        $role = $model::where('model_id',$id)->delete();
        return $role;
    }

    public function assignUserRole($data,$currentModel){
        $model = $this->modelPath.$currentModel;
        return $model::create($data);
    }
}
