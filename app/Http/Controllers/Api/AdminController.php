<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $data['roles']=Role::all();
        $data['admins']=Admin::with('roles')->paginate(10);
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
        //
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
//        return $request->all();
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',],
            'mobile' => ['required','min:8', 'max:15'],
            'role' => ['required'],
            'status' => ['required'],
            'bio' => ['required','min:3', 'max:150'],
        ]);

        $admin=Admin::find($id);

        $admin->update($request->all());
        $admin->roles()->sync($request->role);

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
        Admin::where('id', $id)->delete();

        return 'ok';
    }
}
