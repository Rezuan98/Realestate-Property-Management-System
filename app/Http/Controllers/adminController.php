<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use Illuminate\Support\Facades\Hash;
class adminController extends Controller
{      
  // start admin dashboard methode
      public function adminDashboard(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.index',compact('profileData'));
      }
      // end admin dashboard methode


    

      //  start admin logout method
      public function destroy(Request $request) 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
          'message' => 'admin logged out successfully',
          'alert-type' => 'success'
        );

        return redirect('/admin/login')->with($notification);
    }
//  end admin logout method


  // start admin login methode
    public function adminLogin(){

      return view('admin.admin_login');
    }
    // end admin login methode
    
    // start admin profile methode
    public function adminProfile(){

      $id = Auth::user()->id;
      $profileData = User::find($id);

      return view('admin.admin_profile',compact('profileData'));
    }
// end admin profile methode








    // start  admin profile update methode
    public function adminProfileUpdate(Request $request){
      $id = Auth::user()->id;
      $data = User::find($id);

      $data->username = $request->username;
      $data->email = $request->email;
      $data->address = $request->address;
      $data->phone = $request->phone;
      if($request->file('photo')){
        $file = $request->file('photo');
        @unlink(public_path('upload/admin_images/'.$data->photo));
        $fileName = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path('upload/admin_images'),$fileName);

        $data['photo'] = $fileName;
      }
      $notification = array(
        'message' => 'admin profile updated successfully',
        'alert-type' => 'success'
      );


      $data->save();
      return redirect()->back()->with($notification);

      

    }
    // end admin profile  update mehtode




    // start update admin password mehtode
    public function adminChangePassword(){
      $id = Auth::user()->id;
      $profileData = User::find($id);

      return view('admin.admin_change_password',compact('profileData'));
    }

    public function adminUpdatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'required|same:new_password',
        ]);
    
        // Check if the old password matches the authenticated user's current password
        if (Hash::check($request->old_password, Auth::user()->password)) {
            // Update the user's password
            Auth::user()->update([
                'password' => Hash::make($request->new_password),
            ]);
            $notification = array(
                     'message' => 'password changed successfully',
                     'alert-type' => 'success'
                     );
    
            return redirect()->route('admin.change.password')->with($notification);
        } else {

          $notification = array(
                     'message' => 'old password does not match',
                      'alert-type' => 'error');
            return back()->with( $notification);
        }
    }
     // end update admin password mehtode
  
  
  
  }
    




















    //     public function adminUpdatePassword(Request $request){
           









      
//       $request->validate([

       
      

//         'old_password' => 'required',
//         'new_password' => 'required|confirmed',// 'confirmed' requires a matching 'new_password_confirmation' field
//       ]);
//       // match the old password
//       if(Hash::check($request->old_password,auth::user()->password)){
//         // update the new password
//       User::whereID(auth()->user()->id)->update([

//         'password' =>Hash::make($request->new_password)
//       ]);
       
//       $notification = array(
//         'message' => 'password changed successfully',
//         'alert-type' => 'success'
//       );
//     return back()->with($notification); 

        
//       }else{
//         $notification = array(
//           'message' => 'old password does not match',
//           'alert-type' => 'error'
//         );
//       return back()->with($notification); 
//       }

     
//     }
// }
