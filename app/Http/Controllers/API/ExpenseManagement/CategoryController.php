<?php

namespace App\Http\Controllers\API\ExpenseManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\ServicesController;
use App\Http\Traits\OutputTraits;

class CategoryController extends Controller
{
    use OutputTraits;

    public $services;
    public $model = '\ExpenseCategory';

    public function __construct(
        ServicesController $services
    ){
        $this->services = $services;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $category = $this->services->listData($this->model);
        return $this->returnSuccess('success',$category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();
        $data['name']           =   $request->name;
        $data['description']    =   $request->description;

        $category = $this->services->addData($data,$this->model);
        return $this->returnSuccess('success',$category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->services->showData($id,$this->model);
        return $this->returnSuccess('success',$category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['name']           =   $request->name;
        $data['description']    =   $request->description;

        $category = $this->services->updateData($id,$data,$this->model);
        return $this->returnSuccess('success',$category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->services->deleteData($id,$this->model);
        return $this->returnSuccess('success',$role);
    }
}
