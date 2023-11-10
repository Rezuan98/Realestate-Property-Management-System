<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller


{
    public function userDashboard(){

        return view('user.user');
    }
// start userprotile edit methode
public function userProfileEdit(){

    
    $id = Auth::user()->id;
    $userData = User::find($id);

    return view('frontend.dashboard.user_profile_edit',compact('userData'));
} 
// end user profile edit page mthode



// user profile update methode start here

public function userProfileUpdate(Request $request)
{
    $id = Auth::user()->id;
    $userData = User::find($id);

    $userData->username = $request->username;
    $userData->name = $request->name;
    $userData->email = $request->email;
    $userData->address = $request->address;
    $userData->phone = $request->phone;


    if($request->file('photo')){
      $file = $request->file('photo');
      @unlink(public_path('upload/user_images/'.$userData->photo));
      $fileName = date('YmdHi').$file->getClientOriginalName();
      $file->move(public_path('upload/user_images'),$fileName);

      $userData['photo'] = $fileName;
    }
    $notification = array(
      'message' => 'admin profile updated successfully',
      'alert-type' => 'success'
    );


    $userData->save();
    return redirect()->back()->with($notification);

    

  }


// user profile update methode end here

// start change password methode

public function userChangePassword(){

    $id = Auth::user()->id;
      $userData = User::find($id);

      return view('frontend.dashboard.user_change_password',compact('userData'));

}

// end change password methode

// start update password methode
public function userPasswordUpdate(Request $request){

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
    
            return redirect()->route('user.change.password')->with($notification);
        } else {

          $notification = array(
                     'message' => 'old password does not match',
                      'alert-type' => 'error');
            return back()->with( $notification);
        }
    }
     // end update user password mehtode
  
}
// end  update password methode

// start logout methhode
    public function destroy(Request $request) 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Loged out Successfully',
             'alert-type' => 'error');

        return redirect('/login')->with($notification);
    }
    // end logout methode  
}

