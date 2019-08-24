<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seo= Seo::orderBy('id', 'DESC')->take(1)->get();
        return $seo;

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
            'web_title' =>'required|min:5|max:100',
            'web_admin' =>'required|min:2|max:100',
            'meta_tag' =>'required|min:2|max:200',
            'meta_description' =>'required|min:2|max:500',
        ]);


        Seo::create([
            'web_title'=>$request->input('web_title'),
            'web_admin'=>$request->input('web_admin'),
            'meta_tag'=>$request->input('meta_tag'),
            'meta_description'=>$request->input('meta_description'),
        ]);

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
       $this->validate($request->all(), [
            'web_title' =>'required|min:5|max:100',
            'web_admin' =>'required|min:2|max:100',
            'meta_tag' =>'required|min:2|max:200',
            'meta_description' =>'required|min:2|max:500',
        ]);


        $seo=Seo::find(1);
        $seo->update([
            'web_title'=>$request->input('web_title'),
            'web_admin'=>$request->input('web_admin'),
            'meta_tag'=>$request->input('meta_tag'),
            'meta_description'=>$request->input('meta_description'),
        ]);

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
        Seo::find($id)->delete();
        return 'ok';
    }
}
