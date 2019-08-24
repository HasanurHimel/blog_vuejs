<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission_for;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class PermissionForController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions_for=\App\Models\Permission_for::orderBy('name', 'DESC')->paginate(10);
        return $permissions_for;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=$this->validate($request, [
            'name'=>'required|min:2|unique:permission_fors'

        ]);


        Permission_for::create($request->all());


        return 'ok';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'ok';
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
        $validator=$this->validate($request, [
            'name'=>'required|min:2|unique:permission_fors'

        ]);

        $permission_for=Permission_for::find($id);

        $permission_for->update($request->all());

        return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission_for::find($id)->delete();
        return 'ok';
    }
}
