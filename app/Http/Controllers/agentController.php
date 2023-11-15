<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class agentController extends Controller
{
    public function agentDashboard(){

        return view('agent.agent_Dashboard');
    }
    
    
    
    public function destroy(Request $request) 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function agentLogin(){
        


        return view('agent.agent_login');
    }
}
