<?php

namespace App\Http\Controllers\Api;

use App\Models\Carousel;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carousels=Carousel::orderBy('id', 'DESC')->paginate(10);
        return $carousels;
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
            'carousel_caption'=>'required|string|max:150',
            'photo'=>'required',
            'publication_status'=>'required',
        ]);

        if ($request->photo){
            $name=time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            $directory=public_path('images/carousel/');

            Image::make($request->photo)->save($directory.$name);

        }


        Carousel::create([
            'carousel_caption'=>$request->carousel_caption,
            'photo'=>$name,
            'publication_status'=>$request->publication_status,
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
        $this->validate($request,[
            'carousel_caption'=>'required|string|max:150',
//            'photo'=>'required',
            'publication_status'=>'required',
        ]);

        $carousel=Carousel::findOrFail($id);
        if ($request->photo!==$carousel->photo){
//            $existimage=$user->photo;
            $name=time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            $directory=public_path('images/carousel/');
            if ($carousel->photo){
                unlink($directory.$carousel->photo);
            }
            Image::make($request->photo)->save($directory.$name);

            $carousel->update([
                'photo'=>$name,
            ]);

        }
        $carousel->update([
            'carousel_caption'=>$request->carousel_caption,
            'publication_status'=>$request->publication_status,
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
        Carousel::findOrFail($id)->delete();
        return 'ok';
    }
}
