<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission;
use App\Models\Permission_for;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $data['permissions_for']=Permission_for::select('id', 'name')->orderBy('name', 'ASC')->get();


        $data['permissions']=Permission::with('permission_for')->orderBy('name', 'ASC')->paginate(10);
        return $data;
    }


    public function permission_for_data(){

        return 'ok';
        $permissions_for=Permission_for::select('id', 'name')->orderBy('name', 'ASC')->get();

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
        $this->validate($request, [
            'name'=>'required|min:2|max:50|unique:permissions',
            'permission_for_id'=>'required'
        ]);


        Permission::create($request->all());


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
        $this->validate($request,[
            'name'=>'required|min:2|max:50',
            'permission_for_id'=>'required'
        ]);


        $permission=Permission::find($id);
        $permission->update($request->all());

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
        $permission=Permission::find($id)->delete();
        return 'ok';
    }
}
