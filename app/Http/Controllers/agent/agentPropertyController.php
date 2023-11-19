<?php
namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\property;

use App\Models\multi_image;
use App\Models\facilities;
use App\Models\amenities;
use App\Models\propertyType;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class agentPropertyController extends Controller
{
    public function agentAllProperty(){
        $id = Auth::user()->id;
        $property = property::where('agent_id',$id)->latest()->get();

        return view('agent.property.all_property',compact('property'));
    }

    public function agentAddProperty(){
     

        $propertyType = propertyType::latest()->get();
        $amenities = amenities::latest()->get();
       


        return view('agent.property.add_property',compact('propertyType','amenities'));
    }

    public function agentStoreProperty(Request $request){
          
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
              'agent_id' => Auth::user()->id,
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
   return redirect()->route('agent.all.property')->with( $notification);

        
    }


    // start methode for edit property 
    public function agentEditProperty($id){
        

        $facilities = facilities::where('property_id',$id)->get();
        $property = property::findOrFail($id);
  
        $type = $property->amenities_id;
        $property_amenities = explode(',',$type);

        $multiimage = multi_image::where('property_id',$id)->get();

        $propertyType = propertyType::latest()->get();
        $amenities = amenities::latest()->get();
       


        return view('agent.property.edit_property',compact('property','propertyType','amenities','property_amenities','multiimage','facilities'));


}

public function agentUpdateProperty(Request $request){

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
        'agent_id' => Auth::user()->id,
        'longitude' => $request->longitude,
        'status' =>1,
      
        'updated_at'   => carbon::now(),



    ]);
    $notification = array(
        'message' => 'Data updated Successfully',
         'alert-type' => 'success');
return redirect()->route('agent.all.property')->with( $notification);


 }
  //  start property thumnail update methode

  public function agentUpdatePropertyThumbnail(Request $request)
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
 public function agentUpdatePropertyMultiimage(Request $request){

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

   public function agentPropertyMultiimageDelete($id){

    $old_img = multi_image::findOrFail($id);
    unlink($old_img->photo_name);

    multi_image::findOrFail($id)->delete();

    $notification = array(
        'message' => 'Property Image Deleted Successfully',
         'alert-type' => 'danger');
return redirect()->back()->with($notification);


   }

   public function agentStoreNewMultiimage(Request $request){

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



   public function agentUpdatePropertyFacilities(Request $request){

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


  public function agentDeleteProperty($id){

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


  public function agentDetailsProperty($id){

    $facilities = facilities::where('property_id',$id)->get();
    $property = property::findOrFail($id);

    $type = $property->amenities_id;
    $property_amenities = explode(',',$type);

    $multiimage = multi_image::where('property_id',$id)->get();

    $propertyType = propertyType::latest()->get();
    $amenities = amenities::latest()->get();
   


    return view('agent.property.details_property',compact('property','propertyType','amenities','property_amenities','multiimage','facilities'));

    
 }
  }


