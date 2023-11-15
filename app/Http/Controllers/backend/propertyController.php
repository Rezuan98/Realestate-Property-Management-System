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
            Image::make($img)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
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
        

        $facilities = facilities::where('property_id',$id)->get();
        $property = property::findOrFail($id);
  
        $type = $property->amenities_id;
        $property_amenities = explode(',',$type);

        $multiimage = multi_image::where('property_id',$id)->get();

        $propertyType = propertyType::latest()->get();
        $amenities = amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();


        return view('backend.property.edit_property',compact('property','propertyType','amenities','activeAgent','property_amenities','multiimage','facilities'));

        
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

    //  start property thumnail update methode

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
     }//  end property thumnail update methode

     //  start property multiimage update methode
   public function updatePropertyMultiimage(Request $request){

    $imgs = $request->multi_img;

    foreach($imgs as $id => $img){

        $imgDel = multi_image::findOrFail($id);
        unlink($imgDel->photo_name);

        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
        $upload_path = 'upload/property/multi_image/'.$make_name;


        multi_image::where('id',$id)->update([

            'photo_name' => $upload_path,
            'updated_at' => carbon::now(),

        ]);

        $notification = array(
            'message' => 'Property Image updated Successfully',
             'alert-type' => 'success');
   return redirect()->back()->with($notification);
    }

   }

   public function deletePropertyMultiimage($id){

    $old_img = multi_image::findOrFail($id);
    unlink($old_img->photo_name);

    multi_image::findOrFail($id)->delete();

    $notification = array(
        'message' => 'Property Image Deleted Successfully',
         'alert-type' => 'danger');
return redirect()->back()->with($notification);


   }

   public function storeNewMultiimage(Request $request){

    $new_multi = $request->imageid;
    $image = $request->file('multiimage');

 $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
Image::make($image)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
    $uploadPath = 'upload/property/multi_image/'.$make_name;

    multi_image::insert([
        'property_id' => $new_multi,
        'photo_name' => $uploadPath,
        'created_at' => Carbon::now(), 
    ]);

$notification = array(
        'message' => 'Property Multi Image Added Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification); 
   }
  public function updatePropertyFacilities(Request $request){

    $pid = $request->id;

    if($request->facility_name == Null){

        return redirect()->back();
    }else {
        facilities::where('property_id',$pid)->delete();

        $facilities = count($request->facility_name);

        

            for($i = 0; $i < $facilities; $i++){

                $fcount = new facilities();

                $fcount ->property_id = $pid;
                $fcount -> facility_name = $request->facility_name[$i];
                $fcount -> distance = $request->distance[$i];
                $fcount->save();


            
         }
        }
         $notification = array(
            'message' => 'Property facility updated Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with($notification); 
    

  }

     //  end property thumnail update methode


     public function deleteProperty($id){

       $property = property::findOrFail($id);
       unlink($property->property_thumnail);

       property::findOrFail($id)->delete();

       $image = multi_image::where('property_id',$id)->get();

       foreach($image as $img){
        unlink($img->photo_name);
        multi_image::where('property_id',$id)->delete();
       }

       $facilitiesData = facilities::where('property_id',$id)->get();
       foreach($facilitiesData as $item){
        $item->facility_name;
        facilities::where('property_id',$id)->delete();
       }

        $notification = array(
            'message' => 'Data delete Successfully',
             'alert-type' => 'success');
   return redirect()->route('all.property')->with( $notification);


     }
     public function detailsProperty($id){
        

        $facilities = facilities::where('property_id',$id)->get();
        $property = property::findOrFail($id);
  
        $type = $property->amenities_id;
        $property_amenities = explode(',',$type);

        $multiimage = multi_image::where('property_id',$id)->get();

        $propertyType = propertyType::latest()->get();
        $amenities = amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();


        return view('backend.property.details_property',compact('property','propertyType','amenities','activeAgent','property_amenities','multiimage','facilities'));

        
     }

     public function inactiveProperty(Request $request){

        $pid = $request->id;

        property::findOrFail($pid)->update([

            'status' => 0,
        ]);
        $notification = array(
            'message' => 'property inactived Successfully',
             'alert-type' => 'success');
   return redirect()->route('all.property')->with( $notification);

     }

     public function activeProperty(Request $request){

        $pid = $request->id;

        property::findOrFail($pid)->update([

            'status' => 1,
        ]);
        $notification = array(
            'message' => 'property inactived Successfully',
             'alert-type' => 'success');
   return redirect()->route('all.property')->with( $notification);

     }
}
