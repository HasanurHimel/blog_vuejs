<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        $categories=Category::orderBy('id', 'DESC')->paginate(10);
        return $categories;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' =>'required|min:3|max:50|unique:categories',
            'category_description' =>'required|min:3|max:150',
            'publication_status' =>'required',
        ]);



        Category::create([
            'category_name'=>trim($request->input('category_name')),
            'slug'=>str_slug($request->input('category_name')),
            'category_description'=>trim($request->input('category_description')),
            'publication_status'=>$request->input('publication_status'),
        ]);

        return 'ok';
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' =>'required|min:3|max:50',
            'category_description' =>'required|min:3|max:150',
            'publication_status' =>'required',
        ]);




            $category=Category::find($id);
            $category->update([
                'category_name'=>trim($request->input('category_name')),
                'slug'=>str_slug($request->input('category_name')),
                'category_description'=>trim($request->input('category_description')),
                'publication_status'=>$request->input('publication_status'),
            ]);



        return 'ok';


    }


    public function destroy($id)
    {
        Category::find($id)->delete();


        return 'ok';
    }
}
