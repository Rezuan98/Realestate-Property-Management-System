<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
class AuthenticatedSessionController extends Controller
{
     public function create(){

          return view('auth.signin');
     }
    /**
     * Display the login view.
     */
    // public function create(): View
    // {
    //     return view('admin.admin_login');
    // }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $id = Auth::user()->id;
        $userData = User::find($id);
        $userName = $userData->name;
        $notification = array(
          'message' => $userName. 'Logged in successfully',
          'alert-type' => 'success'
        );

        $url = '';
        if($request->user()-> role === 'admin'){
             $url = '/admin/dashboard';
        }elseif($request->user()-> role === 'agent'){
             $url = '/agent/dashboard';
        }elseif($request->user()-> role === 'user'){
             $url = '/user/dashboard';
        }
       return redirect()->intended($url)->with( $notification);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('auth.signin');
    }
}
