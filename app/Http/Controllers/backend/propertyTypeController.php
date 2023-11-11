<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\propertyType;
use App\models\amenities;

class propertyTypeController extends Controller
{
    public function allType(){

        $types = propertyType::latest()->get();
        return view('backend.type.all_type',compact('types'));
    }

    public function addType(){

        return view('backend.type.add_type');
    }

    public function storeType(Request $request){

        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required',
            
        ]);

        propertyType::insert([

            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);
        $notification = array(
            'message' => 'Property Type Added Successfully',
             'alert-type' => 'success');
   return redirect()->route('all.type')->with($notification);


    }

    public function editType($id){
        $types = propertyType::findOrFail($id);
        return view('backend.type.edit_type',compact('types'));
    }

    public function updateType(Request $request){

        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required',
            
        ]);

        $pid = $request->id;
        propertyType::findOrFail($pid)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);
        $notification = array(
            'message' => 'Property Type Updated Successfully',
             'alert-type' => 'success');
   return redirect()->route('all.type')->with($notification);
    }


    public function deleteType($id){

        propertyType::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Type Updated Successfully',
             'alert-type' => 'success');

        return back()->with($notification);
    }


    ////////////for amenities//////////

    public function allAmenities(){

        $amenities = amenities::latest()->get();
        return view('backend.amenities.all_amenities',compact('amenities'));
    }

    public function addAmenities(){

        return view('backend.amenities.add_amenities');
    }
    public function storeAmenities(Request $request){

       

        amenities::insert([

            'amenities_name' => $request->amenities_name,
            
        ]);
        $notification = array(
            'message' => 'Amenities added Successfully',
             'alert-type' => 'success');
   return redirect()->route('all.amenities')->with($notification);
        }

        public function editAmenities($id){
            $amenities = amenities::findOrFail($id);
            return view('backend.amenities.edit_amenities',compact('amenities'));
        }


        public function updateAmenities(Request $request){

           
    
            $pid = $request->id;
            amenities::findOrFail($pid)->update([
                'amenities_name' => $request->amenities_name,

            ]);
            $notification = array(
                'message' => 'Amenities Updated Successfully',
                 'alert-type' => 'success');
       return redirect()->route('all.amenities')->with($notification);
        }

        public function deleteAmenities($id){

            amenities::findOrFail($id)->delete();
    
            $notification = array(
                'message' => 'Amenities deleted Successfully',
                 'alert-type' => 'success');
    
            return back()->with($notification);
        }


       
}
