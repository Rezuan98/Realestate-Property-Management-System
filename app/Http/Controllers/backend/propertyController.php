<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property;
use App\Models\User;
use App\Models\multi_image;
use App\Models\facilities;
use App\Models\amenities;
use App\Models\propertyType;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\Facades\Image;
use Carbon\carbon;


class propertyController extends Controller
{
    public function allProperty(){

        $property = property::latest()->get();
        return view('backend.property.all_property',compact('property'));

    }

    public function addProperty(){
     

        $propertyType = propertyType::latest()->get();
        $amenities = amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();


        return view('backend.property.add_property',compact('propertyType','amenities','activeAgent'));
    }



    public function storeProperty(Request $request){
          
        $ameni = $request->amenities_id;
       $amenities = implode(',',$ameni);

       $pcode = IdGenerator::generate(['table' => 'properties','field' => 'property_code','length' =>'5','prefix' => 'pc']);

       $image = $request->file('property_thumnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;

        $property_id = property::insertGetId([

              'ptype_id' => $request->ptype_id,
              'amenities_id' => $amenities,
              'property_name' => $request->property_name,
              'property_slug' => strtolower(str_replace('','-',$request->property_name)),
              'property_code' => $pcode,
              'property_status' => $request->property_status,

              'lowest_price' => $request->lowest_price,
              'max_price' => $request->max_price,
              'short_des' => $request->short_des,
              'long_des' => $request->long_des,

              'bedrooms' => $request->bedrooms,
              'bathrooms' => $request->bathrooms,
              'garage' => $request->garage,
              'garage_size' => $request->garage_size,
              'property_size' => $request->property_size,
              'property_video' => $request->property_video,
              'address' => $request->address,
              'city' => $request->city,
              'state' => $request->state,
              'postal_code' => $request->postal_code,
              'neighborhood' => $request->neighborhood,
              'latitude' => $request->latitude,
              'featured' => $request->featured,
              'hot' => $request->hot,
              'agent_id' => $request->agent,
              'longitude' => $request->longitude,
              'status' =>1,
              'property_thumnail' =>$save_url,
              
              

        ]);

        // multi image generate from here

        $images = $request->file('multi_img');

        foreach($images as $img){

            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(770,520)->save('upload/property/multi_image/'.$name_gen);
            $upload_path = 'upload/property/multi_image/'.$make_name;


            multi_image::insert([

                'property_id' => $property_id,
                'photo_name' => $upload_path,
                'created_at' => carbon::now(),
            ]);

        }

        // multi image methode ends here


         // facility  methode starts here

         $facilities = count($request->facility_name);

         if($facilities != NULL){

            for($i = 0; $i < $facilities; $i++){

                $fcount = new facilities();

                $fcount ->property_id = $property_id;
                $fcount -> facility_name = $request->facility_name[$i];
                $fcount -> distance = $request->distance[$i];
                $fcount->save();


            }
         }

         $notification = array(
            'message' => 'Data inserted Successfully',
             'alert-type' => 'success');
   return back()->with( $notification);

        
    }

    // start methode for edit property 
     public function editProperty($id){

        $property = property::findOrFail($id);
          
        $type = $property->amenities_id;
        $property_amenities = explode(',',$type);

        $propertyType = propertyType::latest()->get();
        $amenities = amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();


        return view('backend.property.edit_property',compact('property','propertyType','amenities','activeAgent','property_amenities'));

        
     }

     public function updateProperty(Request $request){

        $ameni = $request->amenities_id;
        $amenities = implode(',',$ameni);

        $property_id = $request->id;

        property::findOrFail($property_id)->update([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenities,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace('','-',$request->property_name)),
            
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_des' => $request->short_des,
            'long_des' => $request->long_des,

            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent,
            'longitude' => $request->longitude,
            'status' =>1,
          
            'updated_at'   => carbon::now(),



        ]);
        $notification = array(
            'message' => 'Data updated Successfully',
             'alert-type' => 'success');
   return redirect()->route('all.property')->with( $notification);


     }


     public function updatePropertyThumnail(Request $request)
     {
         $pro_id = $request->id;
         $old_img = $request->old_image;

         $image = $request->file('property_thumnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;
            
        if(file_exists($old_img)){
            unlink($old_img);
        }
        property::findOrFail($pro_id)->update([

            'property_thumnail' => $save_url,
            'updated_at'     => carbon::now(),

        ]);
        $notification = array(
            'message' => 'Property Thumnail updated Successfully',
             'alert-type' => 'success');
   return redirect()->back()->with($notification);
     }


//      public function deleteProperty($pro){

//         property::findOrFail($pro)->delete();

//         $notification = array(
//             'message' => 'Data delete Successfully',
//              'alert-type' => 'success');
//    return redirect()->route('all.property')->with( $notification);


//      }
}
