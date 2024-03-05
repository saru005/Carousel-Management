<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class CarouselController extends Controller
{
    public function index(){
        $carousels = Carousel::where('status',1)->orderBy('id', 'DESC')->get();
        return view('carousels.index',compact('carousels'));
    }
    public function create_page(){
        return view('carousels.create');
    }
    public function create(Request $request){
        $validation = Validator::make($request->all(),[
            'image_type' => 'required',
            'image' => 'required|image',
        ]);
        if($validation->fails()){
            return response()->json(['success' => false,'errors'=>$validation->errors()]);
        }

        $image = $request->file('image');
        $image_name = uniqid().'.'.$image->getClientOriginalExtension();
        $directory = public_path('images');
        if(!File::exists($directory)){
            File::makeDirectory($directory, 0777, true, true);
        }
        $image->move($directory,$image_name);
    
        $data = [
            'image_type'=>$request->image_type,
            'image_name'=>$image_name ?? null,
            'status'=>1,
        ];
        try{
            $carousel = Carousel::create($data);
        }catch(Exception $e){
            return response()->json(['success'=>false,'error' => $e->getMessage()]);
        }
        return response()->json(['success'=>true,'message' => 'Carousel created successfully']);
    }
    public function edit_page($id){
        $id = base64_decode($id);
        $carousel = Carousel::where('id',$id)->first();
        return view('carousels.edit',compact('carousel'));
    }
    public function edit(Request $request,$id){
        $id = base64_decode($id);
        $validation = Validator::make($request->all(),[
            'image_type' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['success' => false,'errors'=>$validation->errors()]);
        }
        $data = ['image_type'=>$request->image_type];
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $directory = public_path('images');
            if(!File::exists($directory)){
                File::makeDirectory($directory, 0777, true, true);
            }
            $image->move($directory,$image_name);
            $data['image_name'] = $image_name;
        }
        try{
           $status = Carousel::where('id',$id)->update($data);
        }catch(Exception $e){
            return response()->json(['success' => false,'error' => $e->getMessage()]);
        }
        return response()->json(['success' => true,'message'=>'Carousel updated successfully']);
    }
    public function delete(Request $request){
        $id = base64_decode($request->id);
        try{
            $status = Carousel::where('id',$id)->update(['status' => 0]);
         }catch(Exception $e){
             return response()->json(['success' => false,'error' => $e->getMessage()]);
         }
        return response()->json(['success' => true,'message'=>'Carousel Deleted successfully']);
    }
}
