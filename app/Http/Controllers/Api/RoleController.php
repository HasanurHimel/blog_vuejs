<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission_for;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $data['permissions_for']=Permission_for::with('permissions')->orderBy('name', 'ASC')->get();
        $data['roles']=Role::with('permissions')->get();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();
        $this->validate($request,[
            'name'=>'required|min:2|unique:roles'

        ]);


        $role = new Role;
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);

//        it cannot be work ......dond't use below system

//           $role=Role::create([
//               'name'=>$request->name,
//           ]);
//           $role->permissions->sync($request->permission);


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
            'name'=>'required|min:2'

        ]);

//        $role=Role::find($id);
//        $role->update($request->all());


        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);

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
       Role::find($id)->delete();
        return 'ok';
    }
}
